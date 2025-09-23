<?php
declare(strict_types=1);

namespace Dhosting\VectorStore;

use Predis\Client as PredisClient;
use LLPhant\Embeddings\Document;
use LLPhant\Embeddings\DocumentSplitter\DocumentSplitter;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\Redis\RedisVectorStore;

final class DocumentVectorStore
{
    private PredisClient $redis;
    private RedisVectorStore $store;
    /** @var object $embedder must provide embedDocuments(array) and embedText(string) */
    private object $embedder;
    private string $index;
    private int $chunkSize;
    private int $overlap;

    public function __construct(
        PredisClient $redis,
        string $index,
        int $chunkSize = 800,
        int $overlap = 120,
        object $embedder = null
    ) {
        $this->redis = $redis;
        $this->index = $index;
        $this->chunkSize = $chunkSize;
        $this->overlap = $overlap;
        $this->embedder = $embedder ?? new OpenAI3SmallEmbeddingGenerator();
        $this->store = new RedisVectorStore($this->redis, $this->index);
    }

    public function add(string $docId, string $text, array $metadata = []): void
    {
        $docs = [$this->makeDocument($docId, $text, $metadata)];
        $chunks = DocumentSplitter::splitDocuments($docs, $this->chunkSize, ".", $this->overlap);
        $embedded = $this->embedder->embedDocuments($chunks);
        $this->store->addDocuments($embedded);
    }

    public function replace(string $docId, string $text, array $metadata = []): void
    {
        $this->delete($docId);
        $this->add($docId, $text, $metadata);
    }

    public function delete(string $docId): int
    {
        $resp = $this->redis->executeRaw(['FT.SEARCH', $this->index, "@doc_id:{$docId}", 'NOCONTENT']);
        if (!is_array($resp) || empty($resp)) return 0;

        $deleted = 0;
        for ($i = 1; $i < count($resp); $i++) {
            $key = $resp[$i];
            $deleted += (int)$this->redis->del($key);
        }
        return $deleted;
    }

    public function bulkAdd(array $items): void
    {
        $docs = [];
        foreach ($items as $it) {
            $docs[] = $this->makeDocument($it['id'], $it['text'], $it['metadata'] ?? []);
        }
        $chunks = DocumentSplitter::splitDocuments($docs, $this->chunkSize, ".", $this->overlap);
        $embedded = $this->embedder->embedDocuments($chunks);
        $this->store->addDocuments($embedded);
    }

    public function search(string $query, int $k = 5): array
    {
        $qv = $this->embedder->embedText($query);
        $hits = $this->store->similaritySearch($qv, $k);
        $out = [];
        foreach ($hits as $hit) {
            /** @var Document $hit */
            $out[] = [
                'similarity' => $hit->similarity ?? null,
                'content'    => $hit->content,
                'metadata'   => $hit->metadata ?? [],
            ];
        }
        return $out;
    }

    private function makeDocument(string $docId, string $text, array $metadata): Document
    {
        $d = new Document();
        $d->content = $text;
        $d->metadata = array_merge($metadata, [
            'doc_id' => $docId,
            'source' => $metadata['source'] ?? 'inline',
        ]);
        return $d;
    }
}