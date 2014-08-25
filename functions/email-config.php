<?php

function temapadraokmc_mail_config_menu() {
    add_submenu_page('options-general.php', 'Configuração de Email', 'Email Setup', 'manage_options', 'mail-config-menu', 'mail_config_menu');
}

function mail_config_menu() {
    $opt = get_option('temapadraokmc_mail_config_options', new stdClass());
    if(!$opt) {
        $opt = new stdClass();
        $opt->smtpauth = 'nao';
        add_option('temapadraokmc_mail_config_options', $opt);
    }

    if(isset($_GET['act']) && count($_POST) > 0) {
        $opt->host = trim($_POST['host']);
        $opt->port = trim($_POST['port']);
        $opt->smtpsecure = trim($_POST['smtpsecure']);
        $opt->smtpauth = trim($_POST['smtpauth']);
        $opt->username = trim($_POST['username']);
        $opt->password = trim($_POST['password']);
        $opt->to = trim($_POST['to']);
        $opt->email = trim($_POST['email']);
        update_option('temapadraokmc_mail_config_options', $opt);
    }
    ?>
    <style type="text/css">
        .customform {
            width: 25%;
        }
        .customform fieldset {
            margin-top: 5px;
        }
        .customform fieldset legend {
            font-weight: bold !important;
            margin-top: 5px;
        }
        .customform fieldset input[type="text"],
        .customform fieldset input[type="number"],
        .customform fieldset input[type="email"],
        .customform fieldset input[type="password"],
        .customform fieldset select {
            height: 30px;
            width: 100%;
        }
        .customform fieldset .inp_m {
            width: 50%;
        }
        .customform fieldset .inp_x {
            width: 25%;
        }
    </style>
    <h2>Configuração de Email <small>(SMTP)</small></h2>
    <form class="customform" action="options-general.php?page=mail-config-menu&act=save" method="post">
        <fieldset>
            <legend>Configurações do SMTP</legend>
        </fieldset>
        <fieldset>
            <legend>Host</legend>
            <input type="text" id="host" name="host" value="<?php echo $opt->host ?>" />
        </fieldset>
        <fieldset>
            <legend>Porta</legend>
            <input type="text" id="port" name="port" value="<?php echo $opt->port ?>" class="inp_m" />
        </fieldset>
        <fieldset>
            <legend>SMTP Secure</legend>
            <select id="smtpsecure" name="smtpsecure" class="inp_m">
                <option value="">- selecione</option>
                <option value="ssl"<?php echo ($opt->smtpsecure === 'ssl') ? 'selected="selected"' : '' ?>>ssl</option>
                <option value="tls"<?php echo ($opt->smtpsecure === 'tls') ? 'selected="selected"' : '' ?>>tls</option>
            </select>
        </fieldset>
        <fieldset>
            <legend>Requer Autenticação?</legend>
            <input type="radio" id="auth_sim" name="smtpauth" value="sim" <?php echo ($opt->smtpauth === 'sim') ? 'checked="checked"' : '' ?>/> <label for="auth_sim">Sim</label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="auth_nao" name="smtpauth" value="nao" <?php echo ($opt->smtpauth === 'nao') ? 'checked="checked"' : '' ?>/> <label for="auth_nao">Não</label>
        </fieldset>
        <fieldset>
            <legend>Usuário</legend>
            <input type="text" id="username" name="username" value="<?php echo $opt->username ?>" />
        </fieldset>
        <fieldset>
            <legend>Senha</legend>
            <input type="password" id="password" name="password" value="<?php echo $opt->password ?>" />
        </fieldset>
        <hr/>
        <fieldset>
            <legend>Configurações do Destinatário</legend>
        </fieldset>
        <fieldset>
            <legend>Nome</legend>
            <input type="text" id="to" name="to" value="<?php echo $opt->to ?>" />
        </fieldset>
        <fieldset>
            <legend>Email</legend>
            <input type="email" id="email" name="email" value="<?php echo $opt->email ?>" />
        </fieldset>
        <hr/>
        <fieldset>
            <button>Salvar</button>
        </fieldset>
    </form>
    <?php
}

add_action('admin_menu', 'temapadraokmc_mail_config_menu');

function temapadraokmc_smtp($phpmailer) {
    $opt = get_option('temapadraokmc_mail_config_options', new stdClass());

    $phpmailer->Mailer = "smtp";
    $phpmailer->Host = $opt->host;
    $phpmailer->Port = $opt->port;
    $phpmailer->SMTPSecure = $opt->smtpsecure;
    $phpmailer->SMTPAuth = ($opt->smtpauth == "sim") ? TRUE : FALSE;
    if($phpmailer->SMTPAuth) {
        $phpmailer->Username = $opt->username;
        $phpmailer->Password = $opt->password;
    }
}

add_action('phpmailer_init', 'temapadraokmc_smtp');
