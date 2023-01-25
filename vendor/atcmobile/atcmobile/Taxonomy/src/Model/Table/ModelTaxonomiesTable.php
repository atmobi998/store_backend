<?php

namespace Atcmobapp\Taxonomy\Model\Table;

use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * ModelTaxonomies
 *
 * @category Taxonomy.Model
 * @package  Atcmobapp.Taxonomy.Model
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ModelTaxonomiesTable extends AtcmobappTable
{

    public function initialize(array $config)
    {
        $this->setTable('model_taxonomies');
    }
}
