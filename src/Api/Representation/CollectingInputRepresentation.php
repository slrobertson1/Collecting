<?php
namespace Collecting\Api\Representation;

use Collecting\Api\Representation\CollectingPromptRepresentation;
use Collecting\Entity\CollectingInput;
use Omeka\Api\Representation\AbstractRepresentation;
use Zend\ServiceManager\ServiceLocatorInterface;

class CollectingInputRepresentation extends AbstractRepresentation
{
    public function __construct(CollectingInput $resource, ServiceLocatorInterface $serviceLocator)
    {
        $this->resource = $resource;
        $this->setServiceLocator($serviceLocator);
    }

    public function jsonSerialize()
    {
        if ($item = $this->item()) {
            $item = $item->getReference();
        }
        return [
            'o:id' => $this->id(),
            'o-module-collecting:item' => $item,
            'o-module-collecting:prompt' => $this->prompt(),
            // Must use self::displayText() since it's responsible for redaction
            'o-module-collecting:text' => $this->displayText(),
            'o-module-collecting:screen' => $this->screen(),
        ];
    }

    public function id()
    {
        return $this->resource->getId();
    }

    public function item()
    {
        return $this->getAdapter('collecting_items')
            ->getRepresentation($this->resource->getCollectingItem());
    }

    public function prompt()
    {
        return new CollectingPromptRepresentation($this->resource->getPrompt(), $this->getServiceLocator());
    }

    public function text()
    {
        return $this->resource->getText();
    }

    public function screen()
    {
        return $this->resource->getScreen();
    }

    /**
     * Get this input's markup, ready for display.
     *
     * @return string
     */
    public function displayInput()
    {
        $partial = $this->getViewHelper('partial');
        return $partial('common/collecting-item-input.phtml', ['cInput' => $this]);
    }

    /**
     * Get this input's text, ready for display.
     *
     * @return string
     */
    public function displayText()
    {
        $displayText = $this->text();
        $acl = $this->getServiceLocator()->get('Omeka\Acl');
        if (!$acl->userIsAllowed($this->resource, 'view-collecting-input-text')) {
            $displayText = $this->getTranslator()->translate('[private]');
        } elseif ('item' === $this->prompt()->inputType()) {
            try {
                $item = $this->getServiceLocator()->get('Omeka\ApiManager')
                    ->read('items', $displayText)->getContent();
                $displayText = $item->link($item->displayTitle());
            } catch (\Exception $e) {
                $displayText = $this->getTranslator()->translate('[unknown item]');
            }
        }
        return $displayText;
    }
}
