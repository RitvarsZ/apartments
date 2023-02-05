<?php

namespace Tests\Unit;

use App\Http\Services\RssParserService;
use PHPUnit\Framework\TestCase;

class RssParserTest extends TestCase
{
    private RssParserService $rssParserService;

    public function setUp(): void
    {
        parent::setUp();

        $this->rssParserService = new RssParserService();
    }


    public function test_description_parses()
    {
        $description = '<a href="https://www.ss.lv/msg/lv/real-estate/flats/riga/ziepniekkalns/gjion.html"><img align=right border=0 src="https://i.ss.lv/gallery/6/1032/257946/51589028.t.jpg" width="174" height="130" alt=""></a>
		 Pagasts: <b>Ziepniekkalns<br>Vienības g. 126</b><br/>Iela: <b>Vienības g. 126 12..<br>Ziepniekkalns<br>Vienības g. 126</b><br/>Ist.: <b>1</b><br/>m2: <b>20</b><br/>Stāvs: <b>1/1</b><br/>Sērija: <b>P. kara</b><br/>: <b>7 €</b><br/>Cena: <b>140  €/mēn.</b><br/><br/><b><a href="https://www.ss.lv/msg/lv/real-estate/flats/riga/ziepniekkalns/gjion.html">Apskatīt sludinājumu</a></b><br/><br/>
		 ';
        
        $result = $this->rssParserService->parseDescription($description);

        $this->assertEquals('Ziepniekkalns', $result['district']);
        $this->assertEquals('Vienības gatve 126', $result['street']);
        $this->assertEquals('1', $result['rooms']);
        $this->assertEquals('20', $result['m2']);
        $this->assertEquals('1/1', $result['floor']);
        $this->assertEquals('P. kara', $result['series']);
        $this->assertEquals('140', $result['price']);
        $this->assertEquals('€/mēn.', $result['price_unit']);
        $this->assertEquals('7', $result['price_per_m2']);
        $this->assertEquals('https://i.ss.lv/gallery/6/1032/257946/51589028.t.jpg', $result['image_thumbnail']);
    }

    public function test_empty_description()
    {
        $result = $this->rssParserService->parseDescription('');

        $this->assertEquals(null, $result['district']);
        $this->assertEquals(null, $result['street']);
        $this->assertEquals(null, $result['rooms']);
        $this->assertEquals(null, $result['m2']);
        $this->assertEquals(null, $result['floor']);
        $this->assertEquals(null, $result['series']);
        $this->assertEquals(null, $result['price']);
        $this->assertEquals(null, $result['price_unit']);
        $this->assertEquals(null, $result['price_per_m2']);
        $this->assertEquals(null, $result['image_thumbnail']);
    }
}
