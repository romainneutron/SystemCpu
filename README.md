#PHP CPU toolkit

Works only on unix systems. Fork it, port it on windows !

```php
<?php

use Neutron\System\CpuInfo;

$cpuInfos = CpuInfo::detect();

// the total number of core
echo $cpuInfos->getTotalCores();

foreach ($cpuInfos->cpus() as $cpu) {
    // Cpu object available here

    $cpu->getId();          // Cpu Id
    $cpu->getVendor();      // Vendor name
    $cpu->getModel();       // CPU model Id
    $cpu->getModelName();   // CPU model name
    $cpu->getCache();       // the cache per proc
    $cpu->getCores();       // an int for the number of cores
    $cpu->getFlags();       // an array of flags
}

```

#License

MIT licensed
