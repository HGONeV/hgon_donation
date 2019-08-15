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
 * DonationPlace
 */
class DonationPlace extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * address
	 *
	 * @var string
	 */
	protected $address = '';

	/**
	 * zip
	 *
	 * @var int
	 */
	protected $zip = 0;

	/**
	 * city
	 *
	 * @var string
	 */
	protected $city = '';

	/**
	 * longitude
	 *
	 * @var float
	 */
	protected $longitude = 0.0;

	/**
	 * latitude
	 *
	 * @var float
	 */
	protected $latitude = 0.0;

	/**
	 * country
	 *
	 * @var \SJBR\StaticInfoTables\Domain\Model\Country
	 */
	protected $country = null;

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
	 * Returns the address
	 *
	 * @return string $address
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address)
	{
		$this->address = $address;
	}

	/**
	 * Returns the zip
	 *
	 * @return int $zip
	 */
	public function getZip()
	{
		return $this->zip;
	}

	/**
	 * Sets the zip
	 *
	 * @param int $zip
	 * @return void
	 */
	public function setZip($zip)
	{
		$this->zip = $zip;
	}

	/**
	 * Returns the city
	 *
	 * @return string $city
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city)
	{
		$this->city = $city;
	}

	/**
	 * Returns the longitude
	 *
	 * @return float $longitude
	 */
	public function getLongitude()
	{
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param float $longitude
	 * @return void
	 */
	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
	}

	/**
	 * Returns the latitude
	 *
	 * @return float $latitude
	 */
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param float $latitude
	 * @return void
	 */
	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
	}

    /**
     * Returns the country
     *
     * @return \SJBR\StaticInfoTables\Domain\Model\Country $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     *
     * @param \SJBR\StaticInfoTables\Domain\Model\Country $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
