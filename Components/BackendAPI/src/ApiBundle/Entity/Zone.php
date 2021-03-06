<?php

namespace ApiBundle\Entity;

use ApiBundle\GeoJson\GeoJsonFormatter;
use CrEOF\Spatial\PHP\Types\Geography\Polygon;
use CrEOF\Spatial\PHP\Types\Geometry\MultiPolygon;
use Doctrine\ORM\Mapping as ORM;
use GeoJson\GeoJson;
use GeoJson\Geometry\Geometry;
use JMS\Serializer\Annotation as Serializer;

/**
 * Zones.
 *
 * @ORM\Table(
 *     name="zones",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="UNIQ_A0EBC007989D9B62", columns={"slug"})
 *     },
 *     indexes={
 *          @ORM\Index(name="IDX_A0EBC0075373C966", columns={"country"}),
 *          @ORM\Index(name="type", columns={"type"}),
 *          @ORM\Index(name="idx_name", columns={"name"}),
 *          @ORM\Index(name="idx_country_name", columns={"country", "name"}),
 *          @ORM\Index(name="idx_ref", columns={"ref"}),
 *          @ORM\Index(name="idx_ref_official", columns={"ref_official"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\ZoneRepository")
 */
class Zone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255, nullable=false)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_official", type="string", length=255, nullable=true)
     */
    private $refOfficial;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="population", type="integer", nullable=true)
     */
    private $population;

    /**
     * @var string
     *
     * @ORM\Column(name="wikipedia", type="string", length=512, nullable=true)
     */
    private $wikipedia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_from", type="date", nullable=true)
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_until", type="date", nullable=true)
     */
    private $dateUntil;

    /**
     * @var Polygon
     *
     * @ORM\Column(name="shape_polygon", type="polygon", nullable=true)
     * @Serializer\Accessor(getter="getShapePolygon",setter="setShapePolygonFromGeoJson")
     */
    private $shapePolygon;

    /**
     * @var MultiPolygon
     *
     * @ORM\Column(name="shape_multipolygon", type="multipolygon", nullable=true)
     * @Serializer\Accessor(getter="getShapeMultiPolygon",setter="setShapeMultiPolygonFromGeoJson")
     */
    private $shapeMultipolygon;

    /**
     * @var string
     *
     * @ORM\Column(name="centroid", type="point", nullable=true)
     */
    private $centroid;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var ZoneType
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\ZoneType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     *
     * @return $this
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefOfficial()
    {
        return $this->refOfficial;
    }

    /**
     * @param string $refOfficial
     *
     * @return $this
     */
    public function setRefOfficial($refOfficial)
    {
        $this->refOfficial = $refOfficial;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param int $population
     *
     * @return $this
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * @return string
     */
    public function getWikipedia()
    {
        return $this->wikipedia;
    }

    /**
     * @param string $wikipedia
     *
     * @return $this
     */
    public function setWikipedia($wikipedia)
    {
        $this->wikipedia = $wikipedia;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime $dateFrom
     *
     * @return $this
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUntil()
    {
        return $this->dateUntil;
    }

    /**
     * @param \DateTime $dateUntil
     *
     * @return $this
     */
    public function setDateUntil($dateUntil)
    {
        $this->dateUntil = $dateUntil;

        return $this;
    }

    /**
     * @return Geometry|null
     */
    public function getShapePolygon()
    {
        return GeoJsonFormatter::format($this->shapePolygon);
    }

    /**
     * @param string $shapePolygon
     *
     * @return $this
     */
    public function setShapePolygon($shapePolygon)
    {
        $this->shapePolygon = $shapePolygon;

        return $this;
    }

    /**
     * @todo check how this can be achieved
     *
     * @param GeoJson $geoJson
     *
     * @return $this
     */
    public function setShapePolygonFromGeoJson(GeoJson $geoJson)
    {
        $this->shapePolygon = $geoJson;

        return $this;
    }

    /**
     * @return Geometry|null
     */
    public function getShapeMultipolygon()
    {
        return GeoJsonFormatter::format($this->shapeMultipolygon);
    }

    /**
     * @param string $shapeMultipolygon
     *
     * @return $this
     */
    public function setShapeMultipolygon($shapeMultipolygon)
    {
        $this->shapeMultipolygon = $shapeMultipolygon;

        return $this;
    }

    /**
     * @todo check how this can be achieved
     *
     * @param GeoJson $geoJson
     *
     * @return $this
     */
    public function setShapeMultiPolygonFromGeoJson(GeoJson $geoJson)
    {
        $this->shapeMultipolygon = $geoJson;

        return $this;
    }

    /**
     * @return string
     */
    public function getCentroid()
    {
        return $this->centroid;
    }

    /**
     * @param string $centroid
     *
     * @return $this
     */
    public function setCentroid($centroid)
    {
        $this->centroid = $centroid;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return \ApiBundle\Entity\ZoneType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \ApiBundle\Entity\ZoneType $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
