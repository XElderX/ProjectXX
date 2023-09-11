<?php

namespace App\Services\MatchServices\EventsStringTemplates;


class EventsTemplates
{
    public const TYPE_OPPORTUNITY = 'opportunityEvents';
    public const TYPE_SCORE = 'scoreEvents';
    public const TYPE_SAVEGK = 'saveByGkEvents';
    public const TYPE_LASTFOUL = 'lastFoulEvents';

    public const EVENT_TYPES = [
        self::TYPE_OPPORTUNITY, self::TYPE_SCORE, self::TYPE_SAVEGK
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
        ' $teamName $player $position  $player pargriauna priesininka baudos aiksteleje, uz tai jam bus parodyta raufona kortele, bei teks keliauti i rubine. ',
        ' $teamName $position $player tembdamas uz marskineliu varzova nugriauna si priesais vartus uz tai jam teks palikti aikste, kadangi nutraukta labai pavojinga varzovu ataka ',
    ];
}
