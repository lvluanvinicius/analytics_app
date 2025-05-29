<?php
namespace App\Jobs;

use App\Models\MongoDB\Customer;
use App\Models\MongoDB\CustomerDevice;
use App\Models\MongoDB\Device;
use App\Models\MongoDB\Port;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CreateDataFilters implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $ports = array_unique(array_map(function ($d) {
                return $d['PORT'];
            }, $this->data));

            $devices = array_unique(array_map(function ($d) {
                return $d['DEVICE'];
            }, $this->data));

            $customers = array_unique(array_map(function ($d) {
                return $d['NAME'];
            }, $this->data));

            $customerDevice = [];

            foreach ($devices as $device) {
                try {
                    foreach ($customers as $customer) {
                        # code...
                        if (! in_array($customer, $customerDevice)) {
                            array_push($customerDevice, [
                                'DEVICE' => $device,
                                'NAME'   => $customer,
                            ]);
                        }
                    }
                } catch (\Exception $error) {
                    Log::error("Erro CreateDataFilters: [prepare:customerDevice] " . $error->getMessage() . PHP_EOL);
                }
            }

            foreach ($customerDevice as $cd) {
                try {
                    $newCd = new CustomerDevice($cd);

                    if (! $newCd->where('DEVICE', $cd['DEVICE'])->where('NAME', $cd['NAME'])->exists()) {
                        $newCd->save();
                    }

                } catch (\Exception $error) {
                    Log::error("Erro CreateDataFilters: [customerDevice] " . $error->getMessage() . PHP_EOL);
                }
            }

            foreach ($customers as $customer) {
                try {
                    $newCustomer = new Customer(['NAME' => $customer]);
                    if (! $newCustomer->where('NAME', $customer)->exists()) {
                        $newCustomer->save();
                    }
                } catch (\Exception $error) {
                    Log::error("Erro CreateDataFilters: [customers] " . $error->getMessage() . PHP_EOL);
                }
            }

            foreach ($devices as $device) {
                try {
                    $newDevice = new Device(['DEVICE' => $device]);
                    if (! $newDevice->where('DEVICE', $device)->exists()) {
                        $newDevice->save();
                    }
                } catch (\Exception $error) {
                    Log::error("Erro CreateDataFilters: [devices] " . $error->getMessage() . PHP_EOL);
                }
            }

            foreach ($ports as $port) {
                try {
                    $newPort = new Port(['PORT' => $port]);
                    if (! $newPort->where('PORT', $port)->exists()) {
                        $newPort->save();
                    }
                } catch (\Exception $error) {
                    Log::error("Erro CreateDataFilters: [ports] " . $error->getMessage() . PHP_EOL);
                }
            }

            Log::info('Dados auxiliares carregados com sucesso.');

        } catch (\Exception $error) {
            Log::error("Erro no Job de criação dos dados auxiliares: " . $error->getMessage() . PHP_EOL);
        }
    }
}
