<?php

namespace Roseblade\ElementalRows\Elements;

use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use DNADesign\Elemental\Extensions\ElementalAreasExtension;

use SilverStripe\ORM\Fieldtype\DBField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;

class ColumnBlock extends BaseElement
{
	private static $singular_name = 'ColumnBlock Block';

	private static $icon_class = 'font-icon-block-layout-7';

	private static $plural_name = 'ColumnBlock Blocks';

	private static $description = 'Adjustable Column';

	private static $table_name = 'ColumnBlock';

	private static $db = [
		'ColumnSetup' => 'Varchar(4)',
	];

	private static $extensions = [
		ElementalAreasExtension::class
	];


	private static $has_one = array(
		'ElementalArea1' => ElementalArea::class,
		'ElementalArea2' => ElementalArea::class,
		'ElementalArea3' => ElementalArea::class,
		'ElementalArea4' => ElementalArea::class,
	);

	private static $owns = array(
		'ElementalArea1',
		'ElementalArea2',
		'ElementalArea3',
		'ElementalArea4',
	);

	private static $cascade_duplicates = array(
		'ElementalArea1',
		'ElementalArea2',
		'ElementalArea3',
		'ElementalArea4',
	);

	private static $cascade_deletes = [
		'ElementalArea1',
		'ElementalArea2',
		'ElementalArea3',
		'ElementalArea4',
	];

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		Requirements::javascript('roseblade/silverstripe-elemental-rows:client/javascript/elemental_area_edit.js');

		$ColumnSizes 	= [
			"39" 	=> "2 columns: 25% / 75%",
			"66" 	=> "2 columns: 50% / 50%",
			"93" 	=> "2 columns: 75% / 25%",
			"363" 	=> "3 columns: 25% / 50% / 25%",
			"444" 	=> "3 columns: 33% / 33% / 33%",
			"3333" 	=> "4 columns: 25% / 25% / 25% / 25%",
		];

		$fields->addFieldToTab('Root.Main', $ColumnSetup = DropdownField::create(
			'ColumnSetup',
			'Column Configuration',
			$ColumnSizes
		), 'ElementalArea1');

		return $fields;
	}

	public function getType()
	{
		return 'Adjustable Column';
	}

	protected function provideBlockSchema()
	{
		$blockSchema = parent::provideBlockSchema();
		$blockSchema['content'] = $this->getSummary();
		return $blockSchema;
	}

	/**
	 * @return DBField
	 */
	public function getSummary()
	{

		return 'Contains Elements ';
	}

	/**
	 * Retrieve a elemental area relation name which this element owns
	 *
	 * @return string
	 */
	public function getOwnedAreaRelationName($ID)
	{
		if (empty($ID))
		{
			$ID = 0;
		}

		if ($ID == $this->ElementalArea1ID)
		{
			return 'ElementalArea1';
		}
		elseif ($ID == $this->ElementalArea2ID)
		{
			return 'ElementalArea2';
		}
		elseif ($ID == $this->ElementalArea3ID)
		{
			return 'ElementalArea3';
		}
		elseif ($ID == $this->ElementalArea4ID)
		{
			return 'ElementalArea4';
		}
		else
		{
			return 'ElementalArea1';
		}
	}

	public function getObject()
	{
		$DBObject = $this->dbObject('ColumnSetup');
		return $DBObject;
	}

	public function inlineEditable()
	{
		return false;
	}
}
