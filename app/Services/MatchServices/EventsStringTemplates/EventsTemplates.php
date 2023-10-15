<?php

namespace App\Services\MatchServices\EventsStringTemplates;


class EventsTemplates
{
    public const TYPE_OPPORTUNITY = 'opportunityEvents';
    public const TYPE_SCORE = 'scoreEvents';
    public const TYPE_SAVEGK = 'saveByGkEvents';
    public const TYPE_LASTFOUL = 'lastFoulEvents';
    public const TYPE_PENALTYSAVE = 'penaltySaveEvents';
    public const TYPE_PENALTYSCORE = 'penaltyScoreEvents';
    public const TYPE_FKSAVE = 'fkSaveEvents';
    public const TYPE_FKSCORE = 'fkScoreEvents';
    public const TYPE_NDYELLOW = 'ndYellow';
    public const TYPE_YELLOW = 'yellow';
    public const TYPE_ADVANCE1 = 'advance1';
    public const TYPE_ADVANCE2 = 'advance2';
    public const TYPE_ADVANCE3 = 'advance3';
    public const TYPE_NOADVANCE1 = 'noadvance1';
    public const TYPE_NOADVANCE2 = 'noadvance2';
    public const TYPE_NOADVANCE3 = 'noadvance3';
    public const TYPE_SIMPLEGOAL = 'simplegoal';
    public const TYPE_HEADGOAL = 'headgoal';
    public const TYPE_SIMPLEGKSAVE = 'simplegksave';
    public const TYPE_HEADGKSAVE = 'headgksave';

    public const EVENT_TYPES = [
        self::TYPE_OPPORTUNITY, self::TYPE_SCORE, self::TYPE_SAVEGK,
        self::TYPE_PENALTYSAVE, self::TYPE_PENALTYSCORE,
        self::TYPE_FKSAVE, self::TYPE_FKSCORE, self::TYPE_NDYELLOW, self::TYPE_YELLOW,
        self::TYPE_ADVANCE1, self::TYPE_ADVANCE2, self::TYPE_ADVANCE3,
        self::TYPE_NOADVANCE1, self::TYPE_NOADVANCE2, self::TYPE_NOADVANCE3,
        self::TYPE_SIMPLEGOAL, self::TYPE_HEADGOAL, self::TYPE_SIMPLEGKSAVE, self::TYPE_HEADGKSAVE,
    ];

    public $opportunityEvents = [
        '$minute min. $teamName turi proga isvystiti puolima. ',
        '$minute min. $teamName zaidejas $player zaibiskai prabega i prieki, Tai gera proga.. ',
        '$minute min. $teamName zaidejas $player prasibrauna pro varzovu gynyba.. ',
    ];

    public $scoreEvents = [
        ' $teamName pelno nuostabu ivarti!! spirdamas tikslu spyri i desinaji apatinyji vartu kampa. Ivartis pelnytas $minute  min. Ivarcio autorius: $player',
        ' $teamName pelno nuostabu ivarti!! spirdamas tikslu spyri i kairyji apatinyji vartu kampa. Ivartis pelnytas $minute  min. Ivarcio autorius: $player',
        ' $teamName pelno nuostabu ivarti!! spirdamas tikslu spyri i divetke nuo desines puses. Ivartis pelnytas $minute  min. Ivarcio autorius: $player',
        ' $teamName pelno nuostabu ivarti!! spirdamas tikslu spyri i divetke nuo kaires puses. Ivartis pelnytas $minute  min. Ivarcio autorius: $player',
        ' $teamName komandos zaidejas $player spiria tiesiai i vartu viduri... Ir pelno netiketa ivarti, $minute rungtyniu minute',
        ' $teamName komandos zaidejas $player lengvai pasitaises kamuoli, iridena kamuoli i vartu tinkla, taip pelnydamas ivarti, $minute rungtyniu minute',
        ' Visos stadiono akys buvo nukreiptos į $player, kai jis pelnė puikų įvartį $minute min'
    ];

    public $saveByGkEvents = [
        ' $teamName vartininkas atremia pavojingai $player spiriama kamuoli i jo saugomus vartus ',
        ' $teamName vartininkas nepasimeta, ir ryztingai perskaito $player sumanyma ir apsaugo vartus nuo ivarcio ',
        ' $teamName vartininkas ispudingai pirstu galais numusa $player spiriama kamuoli nuo vartu ',
        ' $teamName vartininkas neapsakomos sekmes deka atremia $player spirta smugi ',
    ];

    public $lastFoulEvents = [
        ' $teamName $position  $player prasizengia !!! tai paskutines vilties prazanga, tai jam greiciausia reiskia, jog rungtynes baigtos... taip, teisejas rodo jam raudona kortele!!! ',
        ' $teamName $player $position  $player pargriauna priesininka baudos aiksteleje, uz tai jam bus parodyta raudona kortele, bei teks keliauti i rubine. ',
        ' $teamName $position $player tembdamas uz marskineliu varzova nugriauna si priesais vartus uz tai jam teks palikti aikste, kadangi nutraukta labai pavojinga varzovu ataka ',
    ];

    public $penaltyScoreEvents = [
        ' $teamName komandos zaidejas $player stoja prie 11 metru zymos... Sis ramiai siuncia kamuoli i vartu kampa. Vartininkas nors ir atspejo kamuolio krypti, bet nepavyko atremti. ',
        ' $teamName komandos zaidejas $player musa baudini, ir saltakraujisku smugiu imusa ji, vartininkas net nespejo reguoti i si spyri. ',
        ' $teamName komandos zaidejas $player suklaidina vartinika ir imusa tiksliai baudini, o vartininkas paguldytas priesingoje puseje ',
        ' $teamName komandos zaidejas $player spiria galingai ir nors vartininkas atspeja kamuolio krypti ir net ji liecia, taciau spyris toks galingas, kad vistiek iskrenda i vartus!! ',
    ];

    public $penaltySaveEvents = [
        ' $teamName vartininkas $player atreme smugiuota baudini, taip isgelbedamas savo komanda nuo ivarcio ',
        ' $teamName vartininkas $player parodo savo meistrikuma ir atspeja varzovu baudinio krypti, ir atremdamas ji  ',
        ' $teamName vartininkas $player nors soka i prisinga puse, taciau ivarcio nepraleidzia, kadangi varzovas spiria kamuoli virs vartu!!!  ',
        ' $teamName vartininkas $player pirstu galais nukreipia kamuoli i virpsta!! isgelbydamas savo komanda nuo ivarcio!!  ',
        ' $teamName vartininkas $player pirstu galais nukreipia kamuoli i uzrybi!! isgelbydamas savo komanda nuo ivarcio!!  ',
        ' $teamName vartininkui $player pavyksta atremti varzovu baudini!!!  ',
    ];

    public $fkScoreEvents = [
        ' $teamName komandos zaidejas $player spiria laisva smugi i vartus ir pataiko!!! i vartu kampa, kuri vartininkui buvo neimano apsaugoti. ',
        ' $teamName komandos zaidejas $player spiria palei zeme stipriai kamuoli pataiko ivartus, vartininkas buvo nepasiruosias tokiam smugiui, kadangi net nemate kamuolio!! ',
        ' $teamName komandos zaidejas $player spiria kamuoli ir pataiko i senelei esanti varzovu gyneja ir nuo jo kamuolys pakeicia trajektorija ir krenta i vartus!!! ',
        ' $teamName komandos zaidejas $player spiria galingai laisva baudos smugi ir nors vartininkas atspeja kamuolio krypti ir net ji liecia, taciau spyris toks galingas, kad vistiek iskrenda i vartus!! ',
        ' $teamName komandos zaidejas $player spiria zaibiska spyri link vartu!!  ir nuo skersinio ikrenta i vartus!!! ',
        ' $teamName komandos zaidejas $player spiria sukta spyri ir pataiko nuo virpsto i vartus, vartininkas nieko nebegalejo padeti ',
    ];

    public $fkSaveEvents = [
        ' $teamName vartininkas $player sugauna skersuota kamuoli i baudos aikstele ',
        ' $teamName vartininkas $player atreme pavojinga baudos smugi ',
        ' $teamName vartininkas $player kazkokiu stebuklingu butu atreme klastynga spyri!! isgelbedamas savo vartus nuo ivarcio  ',
        ' $teamName vartininkas $player pirstu galais nukreipia kamuoli i virpsta!! isgelbydamas savo komanda nuo ivarcio!!  ',
        ' $teamName vartininkas $player pirstu galais nukreipia kamuoli i uzrybi!! isgelbydamas savo komanda nuo ivarcio!!  ',
        ' $teamName vartininkui $player pavyksta atremti varzovu pakelta kamuoli ir smugiuota galva i vartus smugi  ',
        ' $teamName vartininkui $player laisvai apsigina nuo pavojingo smugio, kadangi varzovas labai netiksliai smugiuoja ir net nepataiko i vartus  ',
    ];

    public $ndYellow = [
        ' $teamName zaidejas $player uzsidirba antraja geltona kortele. Taigi, jam uz tai tenka palikti aikste ',
    ];

    public $yellow = [
        ' $teamName zaidejas $player uzsidirba geltona kortele ',
    ];

    public $advance1 = [
        ' $teamName zaidejas $player apsivaro varzova $opponent ir tesia puolima ',
        ' $teamName zaidejas $player pergudrauja  $opponent ir prasiskverbia tolyn link varzovu vartu ',
    ];

    public $advance2 = [
        ' $teamName zaidejas $player susizaisdamas su komandos draugu $subPlayer ir apsivarydamas varzova $opponent priarteja link varzovu baudos aiksteles ',
        ' $teamName zaidejas $player nuostabiais judesiais kuria pavojinga proga! palikdamas varzova $opponent uznugaryje ',
    ];

    public $advance3 = [
        ' $teamName zaidejas $player perduoda kamuoli i prieki yra geroje padetyje ',
        ' $teamName zaidejas $player puikiai suzaidzia baudos aiksteleje ',
    ];

    public $noadvance1 = [
        ' $teamName zaidejas $player nesugeba apsivaryti varzova  ir praranda kamuoli ',
        ' $teamName zaidejas $player nesugebejo pergudrauti $opponent ir netenka kamuolio ',
    ];

    public $noadvance2 = [
        ' $teamName zaidejas $player netiksliai bando perduoti kamuoli komandos draugui $subPlayer link varzovu baudos aiksteles. $opponent perskaites si sumanima apsigina ',
        ' $teamName zaidejas $player paleidzia kamuoli varzovui $opponent , kuris ispiria kamuoli kuo toliau',
    ];

    public $noadvance3 = [
        ' $teamName zaidejas $player sumaistyje tarp gyneju praranda kamuoli ir varzovu gynejas $oppDefender perima kamuoli ',
        ' $teamName zaidejas $player neranda galimybiu testi puolimo ',
    ];

    public $simplegoal = [
        ' $teamName zaidejas $player gauna kamuoli komandos is komandos draugo $subPlayer, ir atsidures patogioje padetyje spiria ir pelno ivarti!!!. Vartininkas $opponent bando pasiekti smugiuota kamuoli, taciau to padaryti nepavyko. ',
        ' $teamName zaidejas $player gauna ideau perdavima is $subPlayer, ir pasitaises kamuoli uztikrintai siuncia kamuoli i vartus!!!  nuginkluodamas vartininka $opponent',
    ];

    public $headgoal = [
        ' $teamName zaidejas $player gauna auksta perdavima is komandos draugo $subPlayer, ir galva nukreipia smugi i vartus ir  pelno ivarti!!!. Vartininkas $opponent liko sustinges stoveti dar kelias akimirkas kai suprato jog praleido ivarti. ',
        ' $teamName zaidejas $subPlayer kelia kampini i baudos aikstele, ir $player pasokdamas auksciau uz kitus siuncia galva kamuoli i vartus !!!  nuginkluodamas vartininka $opponent',
    ];

    public $simplegksave = [
        ' $teamName zaidejas $player gauna kamuoli komandos is komandos draugo $subPlayer, ir atsidures patogioje padetyje spiria i vartus!!!. Taciau vartininkas $opponent pademonstruoja nepriekaistingus sugebejimus ir atremia smugi!!! . ',
        ' $teamName zaidejas $player gauna idealu perdavima is $subPlayer, taciau nesugeba nuginkluoti vartininko $opponent ',
    ];

    public $headgksave = [
        ' $teamName zaidejas $player gauna auksta perdavima is komandos draugo $subPlayer, ir galva nukreipia smugi i vartus ir, bet vartininkas $opponent kazkokiu budu sugebejo atremti si bandyma! ',
        ' $teamName zaidejas $subPlayer kelia kampini i baudos aikstele, ir $player pasokdamas auksciau uz kitus ir smugiuoja galva i vartus bet vartininkas sugeba numusti kamuoli nuo vartu ',
    ];
}
