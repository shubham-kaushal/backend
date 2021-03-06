<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Product\Application\Controller\Api\Bindings;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Ergonode\Core\Domain\ValueObject\Language;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ergonode\Product\Domain\Entity\AbstractProduct;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Ergonode\Product\Domain\Query\ProductBindingQueryInterface;
use Ergonode\Api\Application\Response\SuccessResponse;

/**
 * @Route(
 *     name="ergonode_product_bind",
 *     path="products/{product}/bindings",
 *     methods={"GET"},
 *     requirements={"product"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"}
 * )
 */
class GetProductAttributeBindingsAction extends AbstractController
{
    /**
     * @var ProductBindingQueryInterface
     */
    private ProductBindingQueryInterface $query;

    /**
     * @param ProductBindingQueryInterface $query
     */
    public function __construct(ProductBindingQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @IsGranted("PRODUCT_READ")
     *
     * @SWG\Tag(name="Product")
     * @SWG\Parameter(
     *     name="product",
     *     in="path",
     *     type="string",
     *     description="Product ID",
     * )
     * @SWG\Parameter(
     *     name="language",
     *     in="path",
     *     type="string",
     *     required=true,
     *     default="en_GB",
     *     description="Language Code",
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Add multiselect attribute binding",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/product_binding_colection")
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns list of binded attributes",
     * )
     *
     * @ParamConverter(class="Ergonode\Product\Domain\Entity\AbstractProduct")
     *
     *
     * @param Language        $language
     * @param AbstractProduct $product
     *
     * @return Response
     */
    public function __invoke(Language $language, AbstractProduct $product): Response
    {
        $result = $this->query->getBindings($product->getId());

        return new SuccessResponse($result);
    }
}
