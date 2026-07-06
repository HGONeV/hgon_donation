<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Domain\Model;

use Mediadreams\MdNewsAuthor\Domain\Model\NewsAuthor;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Project extends AbstractEntity
{
    protected string $title = '';
    protected string $slug = '';
    protected string $projectCode = '';
    protected string $shortDescription = '';
    protected string $description = '';
    protected string $buttonText = '';
    protected string $hostedButtonId = '';
    protected string $paypalItemName = '';
    protected string $paypalItemNumber = '';
    protected string $paypalBusiness = '';
    protected float $suggestedAmount = 0.0;
    protected string $locationTitle = '';
    protected string $locationDescription = '';
    protected float $latitude = 0.0;
    protected float $longitude = 0.0;
    protected ?NewsAuthor $contactPerson = null;
    protected ?FileReference $image = null;
    protected ObjectStorage $categories;
    protected ObjectStorage $galleryImages;
    protected ObjectStorage $downloads;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->categories = new ObjectStorage();
        $this->galleryImages = new ObjectStorage();
        $this->downloads = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getProjectCode(): string
    {
        return $this->projectCode;
    }

    public function setProjectCode(string $projectCode): void
    {
        $this->projectCode = $projectCode;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getButtonText(): string
    {
        return $this->buttonText;
    }

    public function setButtonText(string $buttonText): void
    {
        $this->buttonText = $buttonText;
    }

    public function getHostedButtonId(): string
    {
        return $this->hostedButtonId;
    }

    public function setHostedButtonId(string $hostedButtonId): void
    {
        $this->hostedButtonId = $hostedButtonId;
    }

    public function getPaypalItemName(): string
    {
        return $this->paypalItemName;
    }

    public function setPaypalItemName(string $paypalItemName): void
    {
        $this->paypalItemName = $paypalItemName;
    }

    public function getPaypalItemNumber(): string
    {
        return $this->paypalItemNumber;
    }

    public function setPaypalItemNumber(string $paypalItemNumber): void
    {
        $this->paypalItemNumber = $paypalItemNumber;
    }

    public function getPaypalBusiness(): string
    {
        return $this->paypalBusiness;
    }

    public function setPaypalBusiness(string $paypalBusiness): void
    {
        $this->paypalBusiness = $paypalBusiness;
    }

    public function getSuggestedAmount(): float
    {
        return $this->suggestedAmount;
    }

    public function setSuggestedAmount(float $suggestedAmount): void
    {
        $this->suggestedAmount = $suggestedAmount;
    }

    public function getLocationTitle(): string
    {
        return $this->locationTitle;
    }

    public function setLocationTitle(string $locationTitle): void
    {
        $this->locationTitle = $locationTitle;
    }

    public function getLocationDescription(): string
    {
        return $this->locationDescription;
    }

    public function setLocationDescription(string $locationDescription): void
    {
        $this->locationDescription = $locationDescription;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function hasCoordinates(): bool
    {
        return $this->latitude !== 0.0 && $this->longitude !== 0.0;
    }

    public function getHasCoordinates(): bool
    {
        return $this->hasCoordinates();
    }

    public function getContactPerson(): ?NewsAuthor
    {
        return $this->contactPerson;
    }

    public function setContactPerson(?NewsAuthor $contactPerson): void
    {
        $this->contactPerson = $contactPerson;
    }

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function setImage(?FileReference $image): void
    {
        $this->image = $image;
    }

    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    public function getGalleryImages(): ObjectStorage
    {
        return $this->galleryImages;
    }

    public function setGalleryImages(ObjectStorage $galleryImages): void
    {
        $this->galleryImages = $galleryImages;
    }

    public function addGalleryImage(FileReference $galleryImage): void
    {
        $this->galleryImages->attach($galleryImage);
    }

    public function removeGalleryImage(FileReference $galleryImage): void
    {
        $this->galleryImages->detach($galleryImage);
    }

    public function getDownloads(): ObjectStorage
    {
        return $this->downloads;
    }

    public function setDownloads(ObjectStorage $downloads): void
    {
        $this->downloads = $downloads;
    }

    public function addDownload(FileReference $download): void
    {
        $this->downloads->attach($download);
    }

    public function removeDownload(FileReference $download): void
    {
        $this->downloads->detach($download);
    }
}
