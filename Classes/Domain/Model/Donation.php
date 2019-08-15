<?php
namespace HGON\HgonDonation\Domain\Model;

/***
 *
 * This file is part of the "HGON Donation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/

/**
 * Donation
 */
class Donation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * type
	 *
	 * @var integer
	 */
	protected $type = 0;

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * shortDescription
	 *
	 * @var string
	 */
	protected $shortDescription = '';

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @cascade remove
	 */
	protected $image = null;

	/**
	 * link
	 *
	 * @var string
	 */
	protected $link = '';

	/**
	 * donationTypeTime
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationTypeTime>
	 * @cascade remove
	 */
	protected $donationTypeTime = null;

	/**
	 * donationTypeMoney
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationTypeMoney>
	 * @cascade remove
	 */
	protected $donationTypeMoney = null;

    /**
     * typolink
     * -> because we got a typolink, just use string instead a pages-Model
     *
     * @var string
     */
    protected $typolink = null;

    /**
     * pages
     * -> filled via hook (when user gives an internal typolink)
     *
     * @var \HGON\HgonDonation\Domain\Model\Pages
     */
    protected $pages = null;

    /**
     * timeRangeStart
     *
     * @var int
     */
    protected $timeRangeStart = 0;

    /**
     * timeRangeEnd
     *
     * @var int
     */
    protected $timeRangeEnd = 0;

    /**
     * txRkwprojectProject
     *
     * @var \HGON\HgonTemplate\Domain\Model\Projects
     */
    protected $txRkwprojectProject = null;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->donationTypeTime = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->donationTypeMoney = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->pages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the type
	 *
	 * @return integer $type
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param integer $type
	 * @return void
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * Returns the shortDescription
	 *
	 * @return string $shortDescription
	 */
	public function getShortDescription()
	{
		return $this->shortDescription;
	}

	/**
	 * Sets the shortDescription
	 *
	 * @param string $shortDescription
	 * @return void
	 */
	public function setShortDescription($shortDescription)
	{
		$this->shortDescription = $shortDescription;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @return void
	 */
	public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
	{
		$this->image = $image;
	}

	/**
	 * Returns the link
	 *
	 * @return string $link
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * Sets the link
	 *
	 * @param string $link
	 * @return void
	 */
	public function setLink($link)
	{
		$this->link = $link;
	}

	/**
	 * Returns the donationTypeTime
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationTypeTime> $donationTypeTime
	 */
	public function getDonationTypeTime()
	{
		return $this->donationTypeTime;
	}

	/**
	 * Sets the donationTypeTime
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationTypeTime> $donationTypeTime
	 * @return void
	 */
	public function setDonationTypeTime(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $donationTypeTime)
	{
		$this->donationTypeTime = $donationTypeTime;
	}

	/**
	 * Adds a donationTypeTime
	 *
	 * @param \HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime
	 * @return void
	 */
	public function addDonationTypeTime(\HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime) {
		$this->donationTypeTime->attach($donationTypeTime);
	}

	/**
	 * Removes a donationTypeTime
	 *
	 * @param \HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTimeToRemove The donationTypeTime to be removed
	 * @return void
	 */
	public function removeDonationTypeTime(\HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTimeToRemove) {
		$this->donationTypeTime->detach($donationTypeTimeToRemove);
	}

	/**
	 * Returns the donationTypeMoney
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationTypeMoney> $donationTypeMoney
	 */
	public function getDonationTypeMoney()
	{
		return $this->donationTypeMoney;
	}

	/**
	 * Sets the donationTypeMoney
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationTypeMoney> $donationTypeMoney
	 * @return void
	 */
	public function setDonationTypeMoney(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $donationTypeMoney)
	{
		$this->donationTypeMoney = $donationTypeMoney;
	}

	/**
	 * Adds a donationTypeMoney
	 *
	 * @param \HGON\HgonDonation\Domain\Model\DonationTypeMoney $donationTypeMoney
	 * @return void
	 */
	public function addDonationTypeMoney(\HGON\HgonDonation\Domain\Model\DonationTypeMoney $donationTypeMoney) {
		$this->donationTypeMoney->attach($donationTypeMoney);
	}

	/**
	 * Removes a donationTypeMoney
	 *
	 * @param \HGON\HgonDonation\Domain\Model\DonationTypeMoney $donationTypeMoneyToRemove The donationTypeTime to be removed
	 * @return void
	 */
	public function removeDonationTypeMoney(\HGON\HgonDonation\Domain\Model\DonationTypeMoney $donationTypeMoneyToRemove) {
		$this->donationTypeMoney->detach($donationTypeMoneyToRemove);
	}

    /**
     * Returns the typolink
     *
     * @return string $typolink
     */
    public function getTypolink()
    {
        return $this->typolink;
    }

    /**
     * Sets the typolink
     *
     * @param string $typolink
     * @return void
     */
    public function setTypolink($typolink)
    {
        $this->typolink = $typolink;
    }

    /**
     * Returns the pages
     *
     * @return \HGON\HgonDonation\Domain\Model\Pages $pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Sets the pages
     *
     * @param \HGON\HgonDonation\Domain\Model\Pages $pages
     * @return void
     */
    public function setPages(\HGON\HgonDonation\Domain\Model\Pages $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Returns the timeRangeStart
     *
     * @return int $timeRangeStart
     */
    public function getTimeRangeStart()
    {
        return $this->timeRangeStart;
    }

    /**
     * Sets the timeRangeStart
     *
     * @param int $timeRangeStart
     * @return void
     */
    public function setTimeRangeStart($timeRangeStart)
    {
        $this->timeRangeStart = $timeRangeStart;
    }

    /**
     * Returns the timeRangeEnd
     *
     * @return int $timeRangeEnd
     */
    public function getTimeRangeEnd()
    {
        return $this->timeRangeEnd;
    }

    /**
     * Sets the timeRangeEnd
     *
     * @param int $timeRangeEnd
     * @return void
     */
    public function setTimeRangeEnd($timeRangeEnd)
    {
        $this->timeRangeEnd = $timeRangeEnd;
    }

    /**
     * Returns the txRkwprojectProject
     *
     * @return \HGON\HgonTemplate\Domain\Model\Projects
     */
    public function getTxRkwprojectProject()
    {
        return $this->txRkwprojectProject;
    }

    /**
     * Sets the txRkwprojectProject
     *
     * @param \HGON\HgonTemplate\Domain\Model\Projects $txRkwprojectProject
     * @return void
     */
    public function setTxRkwprojectProject(\HGON\HgonTemplate\Domain\Model\Projects $txRkwprojectProject)
    {
        $this->txRkwprojectProject = $txRkwprojectProject;
    }
}
