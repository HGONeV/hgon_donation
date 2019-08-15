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
 * DonationTypeTime
 */
class DonationTypeTime extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
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
	 * type
	 *
	 * @var int
	 */
	protected $type = 0;

	/**
	 * timeRequirement
	 *
	 * @var string
	 */
	protected $timeRequirement = '';

	/**
	 * recurring
	 *
	 * @var bool
	 */
	protected $recurring = false;

	/**
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @cascade remove
	 */
	protected $image = null;

	/**
	 * finished
	 *
	 * @var bool
	 */
	protected $finished = false;

	/**
	 * helpersFeedback
	 *
	 * @var string
	 */
	protected $helpersFeedback = '';

	/**
	 * contactPerson
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwAuthors\Domain\Model\Authors>
	 */
	protected $contactPerson = null;

	/**
	 * helpersImage
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @cascade remove
	 */
	protected $helpersImage = null;

	/**
	 * donationPlace
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationPlace>
	 */
	protected $donationPlace = null;

	/**
	 * frontendUser
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwRegistration\Domain\Model\FrontendUser>
	 */
	protected $frontendUser = null;

	/**
	 * maxNumFrontendUser
	 *
	 * @var int
	 */
	protected $maxNumFrontendUser = 1;

    /**
     * pages
     * -> because we got a typolink, just use string instead a pages-Model
     *
     * @var string
     */
    protected $pages = null;

	/**
	 * __construct
	 */
	public function __construct()
	{
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
	protected function initStorageObjects()
	{
		$this->contactPerson = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->donationPlace = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->frontendUser = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the type
	 *
	 * @return int $type
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param int $type
	 * @return void
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * Returns the timeRequirement
	 *
	 * @return string $timeRequirement
	 */
	public function getTimeRequirement()
	{
		return $this->timeRequirement;
	}

	/**
	 * Sets the timeRequirement
	 *
	 * @param string $timeRequirement
	 * @return void
	 */
	public function setTimeRequirement($timeRequirement)
	{
		$this->timeRequirement = $timeRequirement;
	}

	/**
	 * Returns the recurring
	 *
	 * @return bool $recurring
	 */
	public function getRecurring()
	{
		return $this->recurring;
	}

	/**
	 * Sets the recurring
	 *
	 * @param bool $recurring
	 * @return void
	 */
	public function setRecurring($recurring)
	{
		$this->recurring = $recurring;
	}

	/**
	 * Returns the boolean state of recurring
	 *
	 * @return bool
	 */
	public function isRecurring()
	{
		return $this->recurring;
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
	 * Returns the finished
	 *
	 * @return bool $finished
	 */
	public function getFinished()
	{
		return $this->finished;
	}

	/**
	 * Sets the finished
	 *
	 * @param bool $finished
	 * @return void
	 */
	public function setFinished($finished)
	{
		$this->finished = $finished;
	}

	/**
	 * Returns the boolean state of finished
	 *
	 * @return bool
	 */
	public function isFinished()
	{
		return $this->finished;
	}

	/**
	 * Returns the helpersFeedback
	 *
	 * @return string $helpersFeedback
	 */
	public function getHelpersFeedback()
	{
		return $this->helpersFeedback;
	}

	/**
	 * Adds a contactPerson
	 *
	 * @param \RKW\RkwAuthors\Domain\Model\Authors $contactPerson
	 * @return void
	 */
	public function addContactPerson(\RKW\RkwAuthors\Domain\Model\Authors $contactPerson)
	{
		$this->contactPerson->attach($contactPerson);
	}

	/**
	 * Removes a contactPerson
	 *
	 * @param \RKW\RkwAuthors\Domain\Model\Authors $contactPersonToRemove
	 * @return void
	 */
	public function removeQuestion(\RKW\RkwAuthors\Domain\Model\Authors $contactPersonToRemove)
	{
		$this->contactPerson->detach($contactPersonToRemove);
	}

	/**
	 * Returns the contactPerson
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwAuthors\Domain\Model\Authors> $contactPerson
	 */
	public function getContactPerson()
	{
		return $this->contactPerson;
	}

	/**
	 * Sets the contactPerson
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwAuthors\Domain\Model\Authors> $contactPerson
	 * @return void
	 */
	public function setQuestion(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contactPerson)
	{
		$this->contactPerson = $contactPerson;
	}

	/**
	 * Sets the helpersFeedback
	 *
	 * @param string $helpersFeedback
	 * @return void
	 */
	public function setHelpersFeedback($helpersFeedback)
	{
		$this->helpersFeedback = $helpersFeedback;
	}

	/**
	 * Returns the helpersImage
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $helpersImage
	 */
	public function getHelpersImage()
	{
		return $this->helpersImage;
	}

	/**
	 * Sets the helpersImage
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $helpersImage
	 * @return void
	 */
	public function setHelpersImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $helpersImage)
	{
		$this->helpersImage = $helpersImage;
	}

	/**
	 * Returns the donationPlace
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationPlace> $donationPlace
	 */
	public function getDonationPlace()
	{
		return $this->donationPlace;
	}

	/**
	 * Sets the donationPlace
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HGON\HgonDonation\Domain\Model\DonationPlace> $donationPlace
	 * @return void
	 */
	public function setDonationPlace(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $donationPlace)
	{
		$this->donationPlace = $donationPlace;
	}

	/**
	 * Adds a donationPlace
	 *
	 * @param \HGON\HgonDonation\Domain\Model\DonationPlace $donationPlace
	 * @return void
	 */
	public function addDonationPlace(\HGON\HgonDonation\Domain\Model\DonationPlace $donationPlace) {
		$this->donationPlace->attach($donationPlace);
	}

	/**
	 * Removes a donationPlace
	 *
	 * @param \HGON\HgonDonation\Domain\Model\DonationPlace $donationPlaceToRemove The donationPlace to be removed
	 * @return void
	 */
	public function removeDonationPlace(\HGON\HgonDonation\Domain\Model\DonationPlace $donationPlaceToRemove) {
		$this->donationPlace->detach($donationPlaceToRemove);
	}

	/**
	 * Returns the frontendUser
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwRegistration\Domain\Model\FrontendUser> $frontendUser
	 */
	public function getFrontendUser()
	{
		return $this->frontendUser;
	}

	/**
	 * Sets the frontendUser
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwRegistration\Domain\Model\FrontendUser> $frontendUser
	 * @return void
	 */
	public function setFrontendUser(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $frontendUser)
	{
		$this->frontendUser = $frontendUser;
	}

	/**
	 * Adds a frontendUser
	 *
	 * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
	 * @return void
	 */
	public function addFrontendUser(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser) {
		$this->frontendUser->attach($frontendUser);
	}

	/**
	 * Removes a frontendUser
	 *
	 * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUserToRemove The frontendUser to be removed
	 * @return void
	 */
	public function removeFrontendUser(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUserToRemove) {
		$this->frontendUser->detach($frontendUserToRemove);
	}

	/**
	 * Returns the maxNumFrontendUser
	 *
	 * @return int $maxNumFrontendUser
	 */
	public function getMaxNumFrontendUser()
	{
		return $this->maxNumFrontendUser;
	}

	/**
	 * Sets the maxNumFrontendUser
	 *
	 * @param int $maxNumFrontendUser
	 * @return void
	 */
	public function setMaxNumFrontendUser($maxNumFrontendUser)
	{
		$this->maxNumFrontendUser = $maxNumFrontendUser;
	}

    /**
     * Returns the pages
     *
     * @return string $pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Sets the pages
     *
     * @param string $pages
     * @return void
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }
}
