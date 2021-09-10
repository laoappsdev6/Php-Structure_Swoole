<?php

class QsocketClient
{
    private $host = "185.2.102.147";
    // private $host = "192.168.1.119";
    private $port = "33556";
    private $wait = 0.5;
    private $client;

    public function __construct()
    {
        $this->client = new Swoole\Client(SWOOLE_SOCK_TCP);

        $this->connection();
    }
    public function connection()
    {
        if (!$this->client->connect($this->host, $this->port, $this->wait)) {
            exit("Connect failed. Error: {$this->client->errCode}\n");
        }
    }
    public function query($msg)
    {
        $msg = str_replace('\n', '', $msg);
        $query = array("command" => "query", "data" => [$msg]);
        $query = json_encode($query);
        $result = $this->client->send($query);
        $msg = "";

        while ($result) {
            try {
                $data = @$this->client->recv();
                if (empty($data)) {
                    $this->client->close();
                    $json = json_decode($msg, true);
                    return @$json['data'][0];
                } else {
                    $msg .= $data;
                }
                //    sleep(10);
            } catch (Throwable $th) {
                print_r($th);
            }
        }
    }
    public function Close()
    {
        $this->client->close();
    }
}
// $client = new QsocketClient();
// $sql = "select o.object_id objid, o.object_flag oflag, o.driver_job_number driver, d.dtype_id dtype,dt.dtype_name,
// d.device_state dstate,d.online, o.group_id ginfo,g.group_name,d.device_no devno,d.device_sim p,
// d.device_pass dpass,d.install_addr iaddr,o.customer_id cinfo,o.object_kind okind,o.userdef_flag uflag,o.remark,
// dbo.fn_sec2time(60 * isnull(o.time_zone, datediff(minute, getutcdate(), getdate())), '-hm') ztime,
// convert(varchar(20), dbo.fn_to_client_time(d.install_time, 7*60), 20) stamp, convert(varchar(20),
// dbo.fn_to_client_time(d.last_stamp, 7*60), 20) estamp,
// (select driver_name from cfg_driver as dv where o.driver_job_number = dv.job_number) as driver_name
// from cfg_user_purview p,cfg_device d, cfg_object o, cfg_group g,sys_device_type dt
// where p.user_id = 1 and p.purview_id = 1000 and d.object_id = o.object_id and o.group_id = g.group_id and
// d.dtype_id=dt.dtype_id
// and o.group_id in (select * from dbo.fn_group4user(1)) order by o.object_id desc offset 0 rows fetch next 10000 rows only";
// $result = $client->query($sql);
// // echo $result;
// var_dump($result);
// // echo $result;
