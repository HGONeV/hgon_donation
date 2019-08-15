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
 * DonationTypeMoney
 */
class DonationTypeMoney extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @cascade remove
	 */
	protected $image = null;

	/**
	 * donationGoal
	 *
	 * @var string
	 */
	protected $donationGoal = '';

	/**
	 * donationAmountCurrent
	 *
	 * @var string
	 */
	protected $donationAmountCurrent = '';

	/**
	 * donatorCount
	 *
	 * @var int
	 */
	protected $donatorCount = 0;

	/**
	 * frontendUserToInform
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwRegistration\Domain\Model\FrontendUser>
	 */
	protected $frontendUserToInform = null;

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
		$this->frontendUserToInform = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the donationGoal
	 *
	 * @return string $donationGoal
	 */
	public function getDonationGoal()
	{
		return $this->donationGoal;
	}

	/**
	 * Sets the donationGoal
	 *
	 * @param string $donationGoal
	 * @return void
	 */
	public function setDonationGoal($donationGoal)
	{
		$this->donationGoal = $donationGoal;
	}

	/**
	 * Returns the donationAmountCurrent
	 *
	 * @return string $donationAmountCurrent
	 */
	public function getDonationAmountCurrent()
	{
		return $this->donationAmountCurrent;
	}

	/**
	 * Sets the donationAmountCurrent
	 *
	 * @param string $donationAmountCurrent
	 * @return void
	 */
	public function setDonationAmountCurrent($donationAmountCurrent)
	{
		$this->donationAmountCurrent = $donationAmountCurrent;
	}

	/**
	 * Returns the donatorCount
	 *
	 * @return int $donatorCount
	 */
	public function getDonatorCount()
	{
		return $this->donatorCount;
	}

	/**
	 * Sets the donatorCount
	 *
	 * @param int $donatorCount
	 * @return void
	 */
	public function setDonatorCount($donatorCount)
	{
		$this->donatorCount = $donatorCount;
	}

	/**
	 * Returns the frontendUserToInform
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwRegistration\Domain\Model\FrontendUser> $frontendUserToInform
	 */
	public function getFrontendUserToInform()
	{
		return $this->frontendUserToInform;
	}

	/**
	 * Sets the frontendUserToInform
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwRegistration\Domain\Model\FrontendUser> $frontendUserToInform
	 * @return void
	 */
	public function setFrontendUserToInform(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $frontendUserToInform)
	{
		$this->frontendUserToInform = $frontendUserToInform;
	}

	/**
	 * Adds a frontendUserToInform
	 *
	 * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUserToInform
	 * @return void
	 */
	public function addFrontendUserToInform(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUserToInform) {
		$this->frontendUserToInform->attach($frontendUserToInform);
	}

	/**
	 * Removes a frontendUserToInform
	 *
	 * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUserToInformToRemove The frontendUserToInform to be removed
	 * @return void
	 */
	public function removeFrontendUserToInform(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUserToInformToRemove) {
		$this->frontendUserToInform->detach($frontendUserToInformToRemove);
	}
}
