<?php

namespace Roseblade\ElementalRows\Extension;

use DNADesign\Elemental\Models\BaseElement;

use Roseblade\ElementalRows\Elements\ColumnBlock;
use SilverStripe\CMS\Controllers\CMSPageEditController;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * Class BaseElementCMSEditLinkExtension
 *
 * BaseElement can be nested, CMSEditLink() needs to be updated to reflect that
 *
 * @property BaseElementCMSEditLinkExtension|$this $owner
 * @package DNADesign\ElementalList\Extension
 */
class BaseElementCMSEditLinkExtension extends Extension
{

	private static $db = [
		'ColumnClass' => 'Varchar',
		'ColumnClass1' => 'Varchar',
		'ColumnClass2' => 'Varchar',
		'ColumnClass3' => 'Varchar',
		'ColumnClass4' => 'Varchar',
		'RowClass' => 'Varchar',
	];

	/**
	 * @param string $link
	 */
	public function updateCMSEditLink(&$link)
	{
		/** @var $owner BaseElement */
		$owner = $this->owner;
		$relationName = $owner->getAreaRelationName();
		$page = $owner->getPage(true);

		if (!$page)
		{
			return;
		}
		// Lots of If conditions to check if the page is a version of column
		if ($page instanceof Column39 || $page instanceof Column66 || $page instanceof Column93 || $page instanceof Column363 || $page instanceof Column444 || $page instanceof Column3333 || $page instanceof ColumnBlock)
		{
			// nested bock - we need to get edit link of parent block
			$link = Controller::join_links(
				$page->CMSEditLink(),
				'ItemEditForm/field/' . $page->getOwnedAreaRelationName($owner->ParentID) . '/item/',
				$owner->ID
			);

			// remove edit link from parent CMS link
			$link = preg_replace('/\/item\/([\d]+)\/edit/', '/item/$1', $link);
		}
		else
		{
			// block is directly under a non-block object - we have reached the top of nesting chain
			$link = Controller::join_links(
				singleton(CMSPageEditController::class)->Link('EditForm'),
				$page->ID,
				'field/' . $relationName . '/item/',
				$owner->ID
			);
		}

		$link = Controller::join_links(
			$link,
			'edit'
		);
	}
	public function updateCMSFields(FieldList $fields)
	{
		$owner = $this->owner;

		$fields->removeByName('ColumnClass4');
		$fields->removeByName('ColumnClass3');
		$fields->removeByName('ColumnClass2');
		$fields->removeByName('ColumnClass1');
		$fields->removeByName('ColumnClass');
		$fields->removeByName('RowClass');

		if (is_a($owner, Column39::class) || is_a($owner, Column66::class) || is_a($owner, Column93::class) || is_a($owner, Column363::class) || is_a($owner, Column444::class) || is_a($owner, Column3333::class))
		{
			$fields->addFieldToTab(
				'Root.Settings',
				TextField::create(
					'ColumnClass',
					_t(__CLASS__ . '.ColumnClassLabel', 'Custom classes applied on all Columns:')
				)
					->setDescription(_t(__CLASS__ . '.ColumnClassDescription', 'Classes applied to all Columns'))
			);
			$fields->addFieldToTab(
				'Root.Settings',
				TextField::create(
					'RowClass',
					_t(__CLASS__ . '.RowClassLabel', 'Custom classes on Row:')
				)
					->setDescription(_t(__CLASS__ . '.RowClassDescription', 'Classes applied to the Row'))
			);
		}
		else
		{
			$fields->removeByName('ColumnClass');
			$fields->removeByName('RowClass');
		}

		if (is_a($owner, Column39::class) || is_a($owner, Column66::class) || is_a($owner, Column93::class) || is_a($owner, Column363::class) || is_a($owner, Column444::class) || is_a($owner, Column3333::class))
		{
			$fields->addFieldToTab(
				'Root.Settings',
				TextField::create(
					'ColumnClass1',
					_t(__CLASS__ . '.ColumnClass1Label', 'Custom classes on Column: 1')
				)
					->setDescription(_t(__CLASS__ . '.ColumnClass1Description', 'Classes applied to the first Column'))
			);
			$fields->addFieldToTab(
				'Root.Settings',
				TextField::create(
					'ColumnClass2',
					_t(__CLASS__ . '.ColumnClass2Label', 'Custom classes on Column: 2')
				)
					->setDescription(_t(__CLASS__ . '.ColumnClass2Description', 'Classes applied to the second Column'))
			);

			if (is_a($owner, Column363::class) || is_a($owner, Column444::class) || is_a($owner, Column3333::class))
			{

				$fields->addFieldToTab(
					'Root.Settings',
					TextField::create(
						'ColumnClass3',
						_t(__CLASS__ . '.ColumnClass3Label', 'Custom classes on Column: 3')
					)
						->setDescription(_t(__CLASS__ . '.ColumnClass3Description', 'Classes applied to the third Column'))
				);

				if (is_a($owner, Column3333::class))
				{

					$fields->addFieldToTab(
						'Root.Settings',
						TextField::create(
							'ColumnClass4',
							_t(__CLASS__ . '.ColumnClass4Label', 'Custom classes on Column: 4')
						)
							->setDescription(_t(__CLASS__ . '.ColumnClass4Description', 'Classes applied to the fourth Column'))
					);
				}
				else
				{
					$fields->removeByName('ColumnClass4');
				}
			}
			else
			{
				$fields->removeByName('ColumnClass3');
				$fields->removeByName('ColumnClass4');
			}
		}
		else
		{
			$fields->removeByName('ColumnClass1');
			$fields->removeByName('ColumnClass2');
			$fields->removeByName('ColumnClass3');
			$fields->removeByName('ColumnClass4');
		}

		if (is_a($owner, ColumnBlock::class))
		{
			$Object = $owner->getObject();
			// var_dump($Object);

			$fields->addFieldsToTab(
				'Root.Settings',
				[
					TextField::create(
						'ColumnClass',
						_t(__CLASS__ . '.ColumnClassLabel', 'Custom classes applied on all Columns:')
					)
						->setDescription(_t(__CLASS__ . '.ColumnClassDescription', 'Classes applied to all Columns')),
					TextField::create(
						'RowClass',
						_t(__CLASS__ . '.RowClassLabel', 'Custom classes on Row:')
					)
						->setDescription(_t(__CLASS__ . '.RowClassDescription', 'Classes applied to the Row')),
					TextField::create(
						'ColumnClass1',
						_t(__CLASS__ . '.ColumnClass1Label', 'Custom classes on Column: 1')
					)
						->setDescription(_t(__CLASS__ . '.ColumnClass1Description', 'Classes applied to the first Column')),
					TextField::create(
						'ColumnClass2',
						_t(__CLASS__ . '.ColumnClass2Label', 'Custom classes on Column: 2')
					)
						->setDescription(_t(__CLASS__ . '.ColumnClass2Description', 'Classes applied to the second Column'))
				]
			);

			if (($Object == "363") || ($Object == "444") || ($Object == "3333"))
			{

				$fields->addFieldToTab(
					'Root.Settings',

					TextField::create(
						'ColumnClass3',
						_t(__CLASS__ . '.ColumnClass3Label', 'Custom classes on Column: 3')
					)
						->setDescription(_t(__CLASS__ . '.ColumnClass3Description', 'Classes applied to the third Column'))

				);
				if (($Object == "3333"))
				{
					$fields->addFieldToTab(
						'Root.Settings',

						TextField::create(
							'ColumnClass4',
							_t(__CLASS__ . '.ColumnClass4Label', 'Custom classes on Column: 4')
						)
							->setDescription(_t(__CLASS__ . '.ColumnClass4Description', 'Classes applied to the fourth Column'))

					);
				}
			}
		}

		return $fields;
	}

	public function Breadcrumbs()
	{
		return $this->getOwner()->Parent()->Breadcrumbs();
	}

	/**
	 * Returns boolean to indiciate if element is within a column or not
	 *
	 * @return bool
	 */
	public function isInColumn()
	{
		/** Get the owner of the column */
		$owner 		= $this->getOwner();
		$page 		= $owner->getPage();

		if (!empty($page))
		{
			/** Grab the class and check it - is it a column block? */
			$pageClass 	= $page::class;

			if ($pageClass == ColumnBlock::class)
			{
				/** Yes it is. We return true so styles can be adapted etc. */
				return true;
			}
		}

		return false;
	}
}
