<?php

namespace Ad\Domain;

use Doctrine\ORM\Mapping as ORM;
use FileStorage\Domain\Entity\File;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="AdFile",
 *     description="AdFile model",
 * )
 */
#[ORM\Entity(), ORM\Table(name: 'ad_file')]
class AdFile
{
    /**
     * @var File The unique identifier of the ad
     * @OA\Property(
     *     type="Object",
     *     ref="#/components/schemas/File",
     *     description="The file of the ad"
     * )
     */
    #[
        ORM\Id,
        ORM\OneToOne(targetEntity: File::class, fetch: 'EAGER')
    ]
    private File $file;

    /**
     * @var Ad
     * @OA\Property(
     *     type="Object",
     *     ref="#/components/schemas/Ad",
     *     description="The ad of the file"
     * )
     */
    #[
        ORM\ManyToOne(targetEntity: Ad::class, inversedBy: 'photo'),
    ]
    private Ad $ad;

    /**
     * @param Ad $ad_id
     * @param File $file_id
     */
    public function __construct(Ad $ad_id, File $file_id)
    {
        $this->file = $file_id;
        $this->ad = $ad_id;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return AdFile
     */
    public function setFile(File $file): AdFile
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return Ad
     */
    public function getAd(): Ad
    {
        return $this->ad;
    }

    /**
     * @param Ad $ad
     * @return AdFile
     */
    public function setAd(Ad $ad): AdFile
    {
        $this->ad = $ad;
        return $this;
    }
}
