#PHP CPU toolkit

Works only on unix systems. Fork it, port it on windows !

```php
<?php

use Neutron\System\CpuInfo;

$cpuInfos = CpuInfo::detect();

// the total number of core
echo $scpuInfos->getTotalCores();

foreach ($cpuInfos->cpus() as $cpu) {
    // Cpu object available here
}

```

#License

MIT licensed
