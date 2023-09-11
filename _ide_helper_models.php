<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Aliment
 *
 * @property int $id
 * @property string $nom
 * @method static \Database\Factories\AlimentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Aliment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aliment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aliment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Aliment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aliment whereNom($value)
 */
	class Aliment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Alimentation
 *
 * @property int $id
 * @property int $jour
 * @property string $ration
 * @property string|null $quantite
 * @property int|null $prix
 * @property string|null $produit
 * @property string|null $montant
 * @property int|null $pdc_id
 * @property int|null $aliment_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pdc|null $aliment
 * @property-read \App\Models\Pdc|null $pdc
 * @method static \Database\Factories\AlimentationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereAlimentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation wherePdcId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereProduit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereRation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alimentation whereUpdatedAt($value)
 */
	class Alimentation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cercle
 *
 * @property int $id
 * @property string $nom
 * @property int|null $region_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CommuneCercle> $communecercles
 * @property-read int|null $communecercles_count
 * @property-read \App\Models\Region|null $region
 * @method static \Database\Factories\CercleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cercle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cercle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cercle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cercle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cercle whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cercle whereRegionId($value)
 */
	class Cercle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommuneCercle
 *
 * @property int $id
 * @property string $nom
 * @property int|null $cercle_id
 * @property-read \App\Models\Cercle|null $cercle
 * @method static \Database\Factories\CommuneCercleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneCercle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneCercle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneCercle query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneCercle whereCercleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneCercle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneCercle whereNom($value)
 */
	class CommuneCercle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommuneDistrict
 *
 * @property int $id
 * @property string $nom
 * @property int|null $district_id
 * @property-read \App\Models\District|null $district
 * @method static \Database\Factories\CommuneDistrictFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneDistrict newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneDistrict newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneDistrict query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneDistrict whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneDistrict whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommuneDistrict whereNom($value)
 */
	class CommuneDistrict extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Configuration
 *
 * @property int $id
 * @property string $location_type
 * @property string|null $region
 * @property string|null $district
 * @property string|null $scope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $location
 * @method static \Database\Factories\ConfigurationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereLocationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 */
	class Configuration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cycle
 *
 * @property int $id
 * @property string|null $end_at
 * @property string|null $nom
 * @property int|null $infrastructure_id
 * @property int|null $espece_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Alimentation> $alimentations
 * @property-read int|null $alimentations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Depense> $depenses
 * @property-read int|null $depenses_count
 * @property-read \App\Models\Espece|null $espece
 * @property-read \App\Models\Pdc|null $firstPdc
 * @property-read mixed $autoconsommations
 * @property-read mixed $dons
 * @property-read mixed $poisson_produit
 * @property-read mixed $rank
 * @property-read mixed $temps
 * @property-read mixed $ventes
 * @property-read \App\Models\Infrastructure|null $infrastructure
 * @property-read \App\Models\Pdc|null $lastPdc
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pdc> $pdcs
 * @property-read int|null $pdcs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recolte> $recoltes
 * @property-read int|null $recoltes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Traitement> $traitements
 * @property-read int|null $traitements_count
 * @method static \Database\Factories\CycleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle ofEspece($espece)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle recoltesOfType(array $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereEspeceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereInfrastructureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cycle whereUpdatedAt($value)
 */
	class Cycle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Depense
 *
 * @property int $id
 * @property string $description
 * @property float $prix
 * @property int|null $cycle_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle|null $cycle
 * @method static \Database\Factories\DepenseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Depense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Depense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Depense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Depense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depense whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depense wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depense whereUpdatedAt($value)
 */
	class Depense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id
 * @property string $nom
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CommuneDistrict> $communedistricts
 * @property-read int|null $communedistricts_count
 * @method static \Database\Factories\DistrictFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereNom($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Espece
 *
 * @property int $id
 * @property string $nom
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cycle> $cycles
 * @property-read int|null $cycles_count
 * @method static \Database\Factories\EspeceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Espece newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Espece newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Espece query()
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereNom($value)
 */
	class Espece extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ferme
 *
 * @property int $id
 * @property string $nom
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $fullname
 * @property string $phone
 * @property string $zone
 * @property string|null $email
 * @property string $pays
 * @property string|null $region
 * @property string|null $district
 * @property string|null $cercle
 * @property string|null $communecercle
 * @property string|null $communedistrict
 * @property string|null $quartier
 * @property string|null $village
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $cooperative
 * @property int|null $user_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cycle> $cycles
 * @property-read int|null $cycles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Infrastructure> $infrastructures
 * @property-read int|null $infrastructures_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\FermeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereCercle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereCommunecercle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereCommunedistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereCooperative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme wherePays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereQuartier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereVillage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ferme whereZone($value)
 */
	class Ferme extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Infrastructure
 *
 * @property int $id
 * @property string $nom
 * @property float|null $longueur
 * @property float|null $largeur
 * @property float|null $diametre
 * @property float $profondeur
 * @property float $niveau
 * @property float|null $superficie
 * @property float|null $volume
 * @property int|null $ferme_id
 * @property int|null $type_infrastructure_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cycle> $cycles
 * @property-read int|null $cycles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Depense> $depenses
 * @property-read int|null $depenses_count
 * @property-read \App\Models\Ferme|null $ferme
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pdc> $pdcs
 * @property-read int|null $pdcs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recolte> $recoltes
 * @property-read int|null $recoltes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Traitement> $traitements
 * @property-read int|null $traitements_count
 * @property-read \App\Models\TypeInfrastructure|null $typeInfrastructure
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure currentFerme()
 * @method static \Database\Factories\InfrastructureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure query()
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereCycleEnCours()
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereCycleFin()
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereDiametre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereFermeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereLargeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereLongueur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereNiveau($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereProfondeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereSuperficie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereTypeInfrastructureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infrastructure whereVolume($value)
 */
	class Infrastructure extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Membership
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership query()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUserId($value)
 */
	class Membership extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pdc
 *
 * @property int $id
 * @property int $echant
 * @property string|null $achat
 * @property string $poids_moyen
 * @property string $type
 * @property int $nombre
 * @property int|null $mortalite
 * @property int|null $remplacement
 * @property float|null $survivant
 * @property float|null $biomasse
 * @property string|null $poids_total
 * @property string $prise_poids
 * @property int|null $cycle_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Alimentation|null $alimentation
 * @property-read \App\Models\Cycle|null $cycle
 * @method static \Database\Factories\PdcFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereAchat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereBiomasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereEchant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereMortalite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc wherePoidsMoyen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc wherePoidsTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc wherePrisePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereRemplacement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereSurvivant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pdc withoutCharge()
 */
	class Pdc extends \Eloquent {}
}

namespace App\Models\Pdc{
/**
 * App\Models\Pdc\CreatePdc
 *
 * @method static \Database\Factories\Pdc\CreatePdcFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CreatePdc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreatePdc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreatePdc query()
 */
	class CreatePdc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Recolte
 *
 * @property int $id
 * @property string $type
 * @property string $poids_total
 * @property string $prixkg
 * @property float|null $montant
 * @property int|null $cycle_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle|null $cycle
 * @method static \Database\Factories\RecolteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte wherePoidsTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte wherePrixkg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recolte whereUpdatedAt($value)
 */
	class Recolte extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $nom
 * @method static \Database\Factories\RegionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereNom($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Team
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $personal_team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TeamInvitation> $teamInvitations
 * @property-read int|null $team_invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePersonalTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUserId($value)
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TeamInvitation
 *
 * @property int $id
 * @property int $team_id
 * @property string $email
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedAt($value)
 */
	class TeamInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Traitement
 *
 * @property int $id
 * @property string $produit
 * @property string $prix
 * @property int|null $cycle_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle|null $cycle
 * @method static \Database\Factories\TraitementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereProduit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereUpdatedAt($value)
 */
	class Traitement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TypeInfrastructure
 *
 * @property int $id
 * @property string $nom
 * @property int $surface
 * @property int $circulaire
 * @property int $volume
 * @method static \Database\Factories\TypeInfrastructureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure whereCirculaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeInfrastructure whereVolume($value)
 */
	class TypeInfrastructure extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $fullname
 * @property string $email
 * @property string|null $matricule
 * @property string $sexe
 * @property string|null $adresse
 * @property string $role
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $currentTeam
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasName {}
}

