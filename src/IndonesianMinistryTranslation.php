<?php

namespace Laraiba\Translation\Bahasa;

use Laraiba\Resource\Translation\TranslationInterface;
use Laraiba\Resource\Translation\TranslatedAyat;
use Laraiba\Resource\Ayat\Repository\ArrayAyatRepository;
use Laraiba\Resource\Ayat\AyatId;

class IndonesianMinistryTranslation extends ArrayAyatRepository implements TranslationInterface
{
    public function __construct()
    {
        $file = __DIR__ . '/../data/indonesian-ministry.txt';

        $content = explode("\n", file_get_contents($file));

        $data = array();
        foreach ($content as $row) {
            if (empty($row) || preg_match('/^#(.*)$/', $row) === 1) {
                continue;
            }

            $exploded = explode('|', $row);

            $translatedAyat = $this->createTranslatedAyat($exploded);
            $data[$translatedAyat->getSuratNumber()][$translatedAyat->getAyatNumber()] = $translatedAyat;
        }

        parent::__construct($data);
    }

    private function createTranslatedAyat(array $row)
    {
        $ayatId = new AyatId($row[0] . ':' . $row[1]);

        $translatedAyat = new TranslatedAyat($ayatId);
        $translatedAyat->setSuratNumber($row[0]);
        $translatedAyat->setAyatNumber($row[1]);
        $translatedAyat->setText($row[2]);

        return $translatedAyat;
    }
}
