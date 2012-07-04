<?php

namespace Neutron\System;

use Symfony\Component\Process\Process;
use Neutron\System\Exception\RuntimeException;

class CpuInfo
{
    protected $cpus = array();

    public function addCpu(Cpu $cpu)
    {
        $this->cpus[] = $cpu;
    }

    public function cpus()
    {
        return $this->cpus;
    }

    public function getTotalCores()
    {
        $n = 0;

        foreach ($this->cpus as $cpu) {
            $n += $cpu->getCores();
        }

        return $n;
    }

    public static function detect($command = 'cat /proc/cpuinfo')
    {
        $process = new Process($command);
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new RuntimeException(sprintf('Command %s failed', $command));
        }

        $ret = new static();

        foreach (preg_split("/\n\W+/", $process->getOutput()) as $cpuinfos) {

            if (trim($cpuinfos) === '') {
                continue;
            }

            $cpu = new Cpu();

            foreach (preg_split("/\n/", $cpuinfos) as $cpuline) {
                $params = explode(':', $cpuline);

                if (count($params) !== 2) {
                    continue;
                }

                $name = trim($params[0]);
                $value = trim($params[1]);

                switch ($name) {
                    case 'cache size':
                        $cpu->setCache($value);
                        break;
                    case 'cpu cores':
                        $cpu->setCores((int) $value);
                        break;
                    case 'flags':
                        $cpu->setFlags(explode(' ', $value));
                        break;
                    case 'core id':
                        $cpu->setId((int) $value);
                        break;
                    case 'model':
                        $cpu->setModel($value);
                        break;
                    case 'model name':
                        $cpu->setModelName($value);
                        break;
                    case 'vendor_id':
                        $cpu->setVendor($value);
                        break;
                }
            }
            $ret->addCpu($cpu);
        }

        return $ret;
    }
}
