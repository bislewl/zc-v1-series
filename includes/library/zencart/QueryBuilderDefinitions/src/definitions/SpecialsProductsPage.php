<?php
/**
 * Class SpecialsProductsPage
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:  wilt  New in v1.6.0 $
 */
namespace ZenCart\QueryBuilderDefinitions\definitions;

/**
 * Class SpecialsProductsPage
 * @package ZenCart\QueryBuilderDefinitions\definitions
 */
class SpecialsProductsPage extends AbstractDefinition
{
    /**
     *
     */
    public function initQueryAndLayout()
    {
        $this->listingQuery = array(
            'isRandom' => false,
            'isPaginated' => true,
            'pagination' => array('adapterParams' => array('itemsPerPage' => MAX_DISPLAY_SPECIAL_PRODUCTS_INDEX)),
            'filters' => array(
                array(
                    'name' => 'DisplayOrderSorter',
                    'parameters' => array(
                        'defaultSortOrder' => PRODUCT_SPECIALS_LIST_SORT_DEFAULT
                    )
                )
            ),
            'derivedItems' => array(
                array(
                    'field' => 'displayPrice',
                    'handler' => 'displayPriceBuilder'
                ),
                array(
                    'field' => 'productCpath',
                    'handler' => 'productCpathBuilder'
                )
            ),
            'joinTables' => array(
                'TABLE_SPECIALS' => array(
                    'table' => TABLE_SPECIALS,
                    'alias' => 's',
                    'type' => 'left',
                    'addColumns' => true
                ),
                'TABLE_PRODUCTS_DESCRIPTION' => array(
                    'table' => TABLE_PRODUCTS_DESCRIPTION,
                    'alias' => 'pd',
                    'type' => 'left',
                    'fkeyFieldLeft' => 'products_id',
                    'addColumns' => true
                ),
                'TABLE_MANUFACTURERS' => array(
                    'table' => TABLE_MANUFACTURERS,
                    'alias' => 'm',
                    'type' => 'left',
                    'fkeyFieldLeft' => 'manufacturers_id',
                    'addColumns' => true
                )
            ),
            'whereClauses' => array(
                array(
                    'table' => TABLE_PRODUCTS,
                    'field' => 'products_status',
                    'value' => 1,
                    'type' => 'AND'
                ),
                array(
                    'table' => TABLE_SPECIALS,
                    'field' => 'status',
                    'value' => 1,
                    'type' => 'AND'
                ),
                array(
                    'table' => TABLE_PRODUCTS_DESCRIPTION,
                    'field' => 'language_id',
                    'value' => $this->request->getSession()->get('languages_id'),
                    'type' => 'AND'
                )
            ),
        );
        $this->outputLayout = array(
            'boxTitle' => BOX_HEADING_SPECIALS,
            'formatter' => array('class' => 'Columnar',
                                 'template' => 'tpl_listingbox_columnar.php',
                                 'params' => array(
                                     'columnCount' => SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS),
            ),
        );
    }
}
