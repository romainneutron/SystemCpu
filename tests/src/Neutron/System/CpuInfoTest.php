<?php

namespace Neutron\System;

require_once dirname(__FILE__) . '/../../../../src/Neutron/System/CpuInfo.php';

class CpuInfoTest extends \PHPUnit_Framework_TestCase
{

    public function testDetect()
    {

        $command = "echo 'processor	: 0
vendor_id	: GenuineIntel
cpu family	: 6
model		: 42
model name	: Romain Neutron Supa CPU
stepping	: 7
microcode	: 0x1a
cpu MHz		: 1200.000
cache size	: 4096 KB
physical id	: 0
siblings	: 4
core id		: 1
cpu cores	: 12
apicid		: 0
initial apicid	: 0
fpu		: yes
fpu_exception	: yes
cpuid level	: 13
wp		: yes
flags		: sse4
bogomips	: 5586.84
clflush size	: 64
cache_alignment	: 64
address sizes	: 36 bits physical, 48 bits virtual
power management:


processor	: 1
vendor_id	: GenuineIntel
cpu family	: 6
model		: 46
model name	: Otto Von Schirach DSP
stepping	: 7
microcode	: 0x1a
cpu MHz		: 800.000
cache size	: 4096 KB
physical id	: 0
siblings	: 4
core id		: 2
cpu cores	: 11
apicid		: 2
initial apicid	: 2
fpu		: yes
fpu_exception	: yes
cpuid level	: 13
wp		: yes
flags		: sse1 sse2
bogomips	: 5587.05
clflush size	: 64
cache_alignment	: 64
address sizes	: 36 bits physical, 48 bits virtual
power management:


'";

        $cpuinfos = CpuInfo::detect($command);

        $this->assertInstanceOf('\\Neutron\\System\\CpuInfo', $cpuinfos);

        $cpus =$cpuinfos->cpus();
        $this->assertEquals(2, count($cpus));

        $cpu1 = $cpus[0];
        $cpu2 = $cpus[1];

        $this->assertEquals('Romain Neutron Supa CPU', $cpu1->getmodelName());
        $this->assertEquals('Otto Von Schirach DSP', $cpu2->getmodelName());

        $this->assertEquals(23, $cpuinfos->getTotalCores());
        $this->assertEquals(array('sse4'), $cpu1->getFlags());
        $this->assertEquals(array('sse1', 'sse2'), $cpu2->getFlags());
        $this->assertEquals('4096 KB', $cpu1->getCache());
        $this->assertEquals('4096 KB', $cpu2->getCache());
        $this->assertEquals('42', $cpu1->getModel());
        $this->assertEquals('46', $cpu2->getModel());
        $this->assertEquals('GenuineIntel', $cpu1->getVendor());
        $this->assertEquals('GenuineIntel', $cpu2->getVendor());
        $this->assertEquals(1, $cpu1->getId());
        $this->assertEquals(2, $cpu2->getId());
    }
}
