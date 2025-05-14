<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnGera'])) {
    $proced = isset($_POST['procedimento']) ? $_POST['procedimento'] : null;
    $mes = isset($_POST['mes']) ? $_POST['mes'] : null;
    $diai = isset($_POST['diai']) ? intval($_POST['diai']) : null;
    $diaf = isset($_POST['diaf']) ? intval($_POST['diaf']) : null;

    if ($proced == 0) {
        foreach ($rpro as $r) {
            for ($d = $diai; $d <= $diaf; $d++) {
                $dt_agenda = date('Y-m-d', strtotime(date('Y') . '-' . $mes . '-' . $d));
                $dt_ag = $d . '-' . $mes . '-' . date('Y');
                if (date('w', strtotime($dt_ag)) != 0) {
                    for ($hi = $hini; $hi < $hfim; $hi = strtotime('+60 minutes', $hi)) {
                        if ($hi < $hiin || $hi >= $hifi) {
                            $indice++;
                            $hr_comeca = date('H:i', $hi);
                            $horarios[$indice] = array(
                                "data" => $dt_agenda,
                                "horario" => $hr_comeca,
                                "procedimento" => $r['idprocedimentos'],
                                "cliente" => 0,
                                "status" => "A"
                            );
                        }
                    }
                }
            }
        }
    } else {
        for ($d = $diai; $d <= $diaf; $d++) {
            $dt_agenda = date('Y-m-d', strtotime(date('Y') . '-' . $mes . '-' . $d));
            $dt_ag = $d . '-' . $mes . '-' . date('Y');
            if (date('w', strtotime($dt_ag)) != 0) {
                for ($hi = $hini; $hi < $hfim; $hi = strtotime('+60 minutes', $hi)) {
                    if ($hi < $hiin || $hi >= $hifi) {
                        $indice++;
                        $hr_comeca = date('H:i', $hi);
                        $horarios[$indice] = array(
                            "data" => $dt_agenda,
                            "horario" => $hr_comeca,
                            "procedimento" => $proced,
                            "cliente" => 0,
                            "status" => "A"
                        );
                    }
                }
            }
        }
    }

    if (!empty($horarios)) {
        $stmt = $conexao->prepare("INSERT INTO agenda VALUES (default, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $data, $horario, $procedimento, $cliente, $status);

        foreach ($horarios as $v) {
            $data = $v['data'];
            $horario = $v['horario'];
            $procedimento = $v['procedimento'];
            $cliente = $v['cliente'];
            $status = $v['status'];
            $stmt->execute();
        }

        $stmt->close();
        echo "Geração concluída com sucesso!";
    } else {
        echo "O array está vazio, nada a gerar";
    }
}

?>
