<?php
namespace Collecting\Api\Representation;

use Omeka\Api\Representation\AbstractEntityRepresentation;

class CollectingFormRepresentation extends AbstractEntityRepresentation
{
    public function getJsonLdType()
    {
        return 'o-module-collecting:Form';
    }

    public function getJsonLd()
    {
        return [
            'o-module-collecting:label' => $this->label(),
            'o-module-collecting:description' => $this->description(),
            'o-module-collecting:collecting_prompts' => $this->prompts(),
        ];
    }

    public function label()
    {
        return $this->resource->getLabel();
    }

    public function description()
    {
        return $this->resource->getDescription();
    }

    public function owner()
    {
        return $this->getAdapter('users')
            ->getRepresentation($this->resource->getOwner());
    }

    public function prompts()
    {
        $prompts = [];
        $promptsAdapter = $this->getAdapter('collecting_prompts');
        foreach ($this->resource->getCollectingPrompts() as $prompt) {
            $prompts[] = $promptsAdapter->getRepresentation($prompt);
        }
        return $prompts;
    }
}