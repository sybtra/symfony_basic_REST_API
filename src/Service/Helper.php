<?php

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;

class Helper
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private SerializerInterface $serializer,

    ) {
    }    
    /**
     * serialize grouped by properties
     *
     * @param  mixed $entity
     * @param  array $group
     * @return string
     */
    public function serializeGroupedPropertyObject($entity, array $group = ['groups' => 'public'])
    {
        if (is_iterable($entity)) {
            $data = [];
            foreach ($entity as $item) {
                $serializedItem = $this->serializer->serialize($item, 'json', $group);
                $deserializedItem = json_decode($serializedItem, true);
                $data[] = $deserializedItem;
            }
            return $data;
        }

        return $this->serializer->serialize($entity, 'json', $group);
    }
}
