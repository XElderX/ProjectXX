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

    public const EVENT_TYPES = [
        self::TYPE_OPPORTUNITY, self::TYPE_SCORE, self::TYPE_SAVEGK,
        self::TYPE_PENALTYSAVE, self::TYPE_PENALTYSCORE,
        self::TYPE_FKSAVE, self::TYPE_FKSCORE, self::TYPE_NDYELLOW, self::TYPE_YELLOW,
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
}
