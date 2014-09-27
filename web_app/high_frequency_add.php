<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_HIGH_FREQUENCY_ADD);

$comma = 'abate ,abdicate ,aberrant ,abeyance ,abject ,abjure ,abscission ,abscond ,abstemious ,abstinence ,abysmal ,accretion ,accrue ,adamant ,adjunct ,admonish ,adulterate ,aesthetic ,affected ,affinity ,aggrandize ,aggregate ,alacrity ,alchemy ,allay ,alleviate ,alloy ,allure ,amalgamate ,ambiguous ,ambivalence ,ambrosia ,ameliorate ,amenable ,amenity ,amulet ,anachronism ,analgesic ,analogous ,anarchy ,anodyne ,anomalous ,antecedent ,antediluvian ,antipathy ,apathy ,apex ,apogee ,apothegm ,appease ,appellation ,apposite ,apprise ,approbation ,appropriate ,apropos ,arabesque ,archeology ,ardor ,arduous ,argot ,arrest ,artifact ,artless ,ascetic ,asperity ,aspersion ,assiduous ,assuage ,astringent ,asylum ,atavism ,attenuate ,audacious ,austere ,autonomous ,avarice ,aver ,avocation ,avuncular ,axiomatic ,bacchanalian ,banal ,banter ,bard ,bawdy ,beatify ,bedizen ,behemoth ,belie ,beneficent ,bifurcate ,blandishment ,blase ,bolster ,bombastic ,boorish ,bovine ,brazen ,broach ,bucolic ,burgeon ,burnish ,buttress ,cacophonous ,cadge ,callous ,calumny ,canard ,canon ,cant ,cantankerous ,capricious ,captious ,cardinal ,carnal ,carping ,cartography ,caste ,castigation ,cataclysm ,catalyst ,categorical ,caucus ,causal ,caustic ,celestial ,centrifugal ,centripetal ,champion ,chasten ,chicanery ,chivalry ,churlish ,circuitous ,clairvoyant ,clamor ,clique ,coagulate ,cloister ,coalesce ,coda ,codify ,cognizant ,collage ,commensurate ,compendium ,complacent ,complaisant ,complement ,compliant ,compunction ,concave ,conciliatory ,concoct ,concomitant ,condone ,confound ,congenial ,conjugal ,connoisseur ,conscript ,consecrate ,contend ,contentious ,continence ,contrite ,contumacious ,conundrum ,contiguous ,convention ,converge ,convex ,convivial ,convoluted ,copious ,coquette ,cornucopia ,cosmology ,covert ,covetous ,cozen ,craven ,credence ,credo ,daunt ,dearth ,debauchery ,decorum ,defame ,default ,deference ,defunct ,delineate ,demographic ,demotic ,demur ,denigrate ,denizen ,denouement ,deride ,derivative ,desiccate ,desuetude ,desultory ,deterrent ,detraction ,diaphanous ,diatribe ,dichotomy ,diffidence ,diffuse ,digression ,dirge ,disabuse ,discerning ,discomfit ,discordant ,discredit ,discrepancy ,discrete ,discretion ,disingenuous ,disinterested ,disjointed ,dismiss ,disparage ,disparate ,dissemble ,disseminate ,dissident ,dissolution ,dissonance ,distend ,distill ,distrait ,diverge ,divest ,divulge ,doctrinaire ,document ,doggerel ,dogmatic ,dormant ,dross ,dupe ,ebullient ,eclectic ,effervescence ,effete ,efficacy ,effrontery ,egoism ,egotistical ,elegy ,elicit ,elixir ,elysian ,emaciated ,embellish ,emollient ,empirical ,emulate ,encomium ,endemic ,enervate ,engender ,enhance ,entomology ,enuciate ,ephemeral ,epistemology ,equable ,equanimity ,equivocation ,errant ,erudite ,esoteric ,essay ,estimable ,ethnocentric ,etiology ,etymology ,eugenics ,eulogy ,euphemism ,euphoria ,euthanasia ,evince ,evocative ,exacerbate ,exact ,exculpate ,execrable ,exhort ,exigency ,existential ,exorcise ,expatiate ,expatriate ,expiate ,explicate ,expository ,extant ,extemporaneous ,extirpate ,extraneous ,extrapolation ,extrinsic ,facetious ,facilitate ,factotum ,fallacious ,fallow ,fatuous ,fauna ,fawning ,felicitous ,feral ,fervor ,fetid ,fetter ,fiat ,fidelity ,filibuster ,finesse ,fissure ,flag ,fledgling ,flora ,florid ,flourish ,flout ,flux ,foment ,forbearance ,forestall ,formidable ,forswear ,founder ,fracas ,fractious ,fresco ,frieze ,froward ,frugality ,fulminate ,fulsome ,fusion ,futile ,gainsay ,gambol ,garrulous ,gauche ,geniality ,gerrymander ,glib ,goad ,gossamer ,gouge ,grandiloquent ,gregarious ,grouse ,guileless ,guise ,gullible ,gustatory ,halcyon ,hallowed ,harangue ,harrowing ,herbivorous ,hermetic ,heterodox ,hieroglyphics ,hirsute ,histrionic ,homeostasis ,homily ,homogeneous ,hyperbole ,iconoclastic ,idolatry ,igneous ,imbroglio ,immutable ,impair ,impassive ,impecunious ,impede ,impermeable ,imperturbable ,impervious ,impinge ,implacable ,implausible ,implicit ,implode ,imprecation ,impute ,inadvertently ,incarnate ,inchoate ,incongruity ,inconsequential ,incorporate ,incursion ,indeterminate ,indigence ,indolent ,ineluctable ,inert ,ingenuous ,inherent ,innocuous ,insensible ,insinuate ,insipid ,insouciant ,insularity ,insuperable ,intangible ,interdict ,internecine ,interpolate ,interregnum ,intimate ,intractable ,intransigence ,introspective ,inundate ,inured ,invective ,inveigh ,inveigle ,inveterate ,invidious ,irascible ,irresolute ,itinerant ,itinerary ,jaundiced ,jibe ,jocose ,juggernaut ,junta ,juxtapose ,kudos ,labile ,laconic ,lambaste ,lascivious ,lassitude ,latent ,laud ,lethargic ,levee ,levity ,liberal ,libertine ,libido ,lilliputian ,limn ,limpid ,linguistic ,litany ,literati ,litigation ,log ,loquacious ,lucid ,lucre ,luminous ,lustrous ,machiavellian ,machinations ,maelstrom ,magnanimity ,malign ,malinger ,malleable ,maverick ,megalomania ,menagerie ,mendacious ,mendicant ,meretricious ,mesmerize ,metamorphosis ,metaphysics ,meteorological ,meticulous ,mettle ,mettlesome ,microcosm ,militate ,minatory ,minuscule ,minutia ,misanthrope ,miscellany ,miscreant ,misogynist ,mitigate ,mnemonic ,modicum ,mollify ,monolithic ,morose ,motley ,multifarious ,mundane ,necromancy ,negate ,neologism ,neophyte ,nexus ,nonplussed ,nostalgia ,nostrum ,nugatory ,obdurate ,obsequious ,obsequy ,obviate ,occlude ,occult ,odyssey ,officious ,olfactory ,oligarchy ,onerous ,onomatopoeia ,opprobrium ,ornithologist ,oscillate ,ostentatious ,overweening ,paean ,paleontology ,pallid ,panegyric ,paragon ,partisan ,pathological ,patois ,paucity ,pedantic ,pellucid ,penchant ,penurty ,peregrination ,peremptory ,perennial ,perfidious ,perfunctory ,perigee ,permeable ,perturb ,pervasive ,petulant ,phlegmatic ,phoenix ,physiognomy ,piety ,piquant ,pique ,placate ,placid ,plaintive ,plasticity ,platitude ,platonic ,plethora ,plumb ,plume ,plummet ,plutocracy ,porous ,poseur ,pragmatic ,prate ,prattle ,preamble ,precarious ,precept ,precipitate ,precursor ,preempt ,prehensile ,premonition ,presage ,presumptuous ,preternatural ,prevaricate ,primordial ,pristine ,probity ,problematic ,prodigal ,profound ,prohibitive ,proliferate ,propitiate ,propensity ,propriety ,proscribe ,provident ,puissant ,punctilious ,pungent ,purport ,pusillanimous ,quagmire ,quail ,qualified ,qualm ,query ,quibble ,quiescent ,quorum ,raconteur ,rail ,raiment ,ramification ,rarefied ,rationale ,rebus ,recalcitrant ,recant ,recluse ,recondite ,redoubtable ,refractory ,refract ,refulgent ,refute ,regale ,relegate ,remonstrate ,renege ,reparation ,repine ,reprise ,reproach ,reprobate ,repudiate ,rescind ,resolution ,resolve ,reticent ,reverent ,riposte ,rococo ,rubric ,rue ,ruse ,sage ,salacious ,salubrious ,salutary ,sanction ,sardonic ,sartorial ,satiate ,saturate ,saturnine ,satyr ,savor ,schematic ,secrete ,sedition ,sedulous ,seismic ,sensual ,sensuous ,sentient ,servile ,sextant ,shard ,sidereal ,simian ,simile ,sinecure ,singular ,sinuous ,skeptic ,sobriety ,sodden ,solicitous ,soliloquy ,solvent ,somatic ,soporific ,sordid ,specious ,spectrum ,spendthrift ,sporadic ,squalor ,staccato ,stanch ,stentorian ,stigma ,stint ,stipulate ,stolid ,stratified ,striated ,stricture ,strident ,strut ,stultify ,stupefy ,stygian ,subpoena ,subside ,substantiate ,substantive ,subsume ,subversive ,succor ,suffrage ,sundry ,supersede ,supine ,supplant ,suppliant ,supplicant ,supposition ,syllogism ,sylvan ,tacit ,talisman ,tangential ,tautology ,taxonomy ,tenet ,tenuous ,terrestrial ,theocracy ,thespian ,timbre ,tirade ,toady ,tome ,torpor ,torque ,tortuous ,tout ,tractable ,transgression ,transient ,translucent ,travail ,travesty ,treatise ,tremulous ,trepidation ,truculence ,tryst ,anomie ,tumid ,turbid ,turgid ,tutelary ,uncanny ,undulating ,unfeigned ,untenable ,untoward ,usury ,vacillate ,vacuous ,valedictory ,vapid ,variegated ,vaunt ,venal ,vendetta ,venerate ,veracious ,verbose ,vertigo ,vexation ,viable ,vindictive ,virtuoso ,visage ,viscous ,vitiate ,vituperative ,vivisection ,vogue ,volatile ,vortex ,warranted ,wary ,welter ,whimsical ,whimsy ,wistful ,zealot ,zealotry ,de facto ,deviant ,defer ,platonic ,discern ,bionics ,heuristic ,equitable ,guile ,reductionistic ,inertia ,pathos ,pedant ';

$db = new dbHelper;
$db -> ud_connectToDB();

$result = $db->ud_whereQuery('ud_high_frequency');
$data = $db->ud_mysql_fetch_assoc_all($result);

if(!isset($_GET['id']) || empty($_GET['id']))
{
    header('location:high_frequency.php');
}

$result = $db->ud_whereQuery('ud_high_frequency',NULL,array('id'=>$_GET['id']));
$list   = $db->ud_mysql_fetch_assoc($result);

if( $db->ud_getRowCountResult($result)==0)
{
    header('location:high_frequency.php');
}

?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en">

<![endif]--><!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en">

<![endif]--><!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">

<![endif]--><!--[if gt IE 8]>
<!-->
<html class="no-js" lang="en">

<!--<![endif]-->
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Add High Frquency Words - GRE</title>
    <!-- Metadata -->
    <meta content="" name="description" />
    <meta content="" name="keywords" />
    <meta content="" name="author" />
    <?php require 'include/foundation.php'; ?>
    <?php require 'include/datatable.php';?>
    <!-- CSS Styles -->
    <link rel="stylesheet" href="resources/css/common-backend/card.css" />
</head>
<style>
    .table-center
    {
        width: 120px;
        text-align:center !important;
    }
    .no-margin
    {
        margin-bottom:0px;
    }
    .data-container
    {
        height: 200px;
        overflow-y: scroll;
    }
</style>
<?php require 'include/header.php';?>
<div class="row content card" style="margin-top:25px;margin-bottom:25px;">
    <div class="large-12 columns">
        <h3><?php echo $list['name'] ?></h3>
        <div class="row" id="input-div">
            <div class="large-12 columns">
                <textarea style="resize:none;height:200px;" placeholder="Comma Seperated Values.eg Abase,Abate" id="data"><?php echo $comma;?></textarea>
                <input type="button" class="button tiny secondary" id="add" value="Add High Frequency Words"/>
            </div>
        </div>
        <div class="row" style="display:none;" id="loading-div">
            <div class="large-12 columns"  style="text-align:center;">
                <h4>Loading</h4>
                <img src="resources/img/common/ajax-loader.gif"/>
            </div>
        </div>
        <div class="row" style="display:none;" id="data-div">
            <div class="large-12 columns">
                <div class="row">
                    <div class="large-12 columns">
                        <h4>Words Added</h4>
                        <table id="added">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Word</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 columns">
                        <h4>Words Already Present</h4>
                        <table id="present">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Word</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 columns">
                        <h4>Words That were not found</h4>
                        <table id="word">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Word</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="id" value="<?php echo $_GET['id']; ?>">
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
        add_t = $('#added').dataTable(
        {
            "sPaginationType" : "full_numbers"
        });

        var present = $('#present').dataTable(
        {
            "sPaginationType" : "full_numbers"
        });

        var word = $('#word').dataTable(
        {
            "sPaginationType" : "full_numbers"
        });

        $('#add').click(function()
        {
            var data = $.trim($('#data').val());
            var id   = $('#id').val();
            if(data.length>0)
            {
                $('#input-div').hide();
                $('#loading-div').show();

                $.post('include/high_frequency_ajax.php',{id:id,data:data},function(data)
                {
                    var jsonData = JSON.parse(data);
                    var counter = 1;
                    for (var i in jsonData.added)
                    {
                        //add_t.row.add([counter,jsonData.added[i]]).draw();
                        counter++;
                    }
                    var counter = 1;
                    for (var i in jsonData.already)
                    {
                        jsonData.already[i];
                    }

                    $('#loading-div').hide();
                    $('#data-div').show();
                })
                .fail( function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                });
            }
        });
    });
</script>

<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->