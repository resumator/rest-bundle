<?php
namespace Lemon\RestBundle\Serializer;

use Symfony\Component\HttpFoundation\Request;

interface ResourceSerializerInterface
{
    /**
     * @param array|object $data
     * @param string $format
     * @param Request $request
     * @return string
     */
    public function serialize($data, $format, Request $request);

    /**
     * @param string $data
     * @param string $type
     * @param string $format
     * @param Request $request
     * @return mixed
     */
    public function deserialize($data, $type, $format, Request $request);
}
