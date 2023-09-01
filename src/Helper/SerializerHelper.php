<?php
namespace App\Helper;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Serializer helper class.
 */
class SerializerHelper
{
    /**
     * Deserialize data.
     *
     * @param string $data
     * @param string $type
     * @return mixed
     */
    public function deserializeJson(string $data, string $type) : mixed
    {
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
  
        return $serializer->deserialize($data, $type, 'json');
    }
}