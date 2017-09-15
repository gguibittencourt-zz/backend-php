<body style="background-color: #f4f4f4;">
<table style="width: 500px;margin: auto;background-color: #FFFFFF;border: 4px solid #EEE;font-family: arial;font-size: 15px;">
    <tbody>
    <tr>
        <td colspan="2" style="padding: 20px;text-align: center;border: 1px solid #EEE;">
            <img src="https://freiredesign.com/images/freire-design-novo.png" style="width: 400px;">
        </td>
    </tr>
    <tr>
        <td style="padding: 5px;font-weight: bold;">Nome:</td>
        <td style="padding: 5px;">
            <?php echo $nome ?>
        </td>
    </tr>
    <tr style="">
        <td style="padding: 5px;font-weight: bold;">E-mail:</td>
        <td style="padding: 5px;">
            <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px;font-weight: bold;">Assunto:</td>
        <td style="padding: 5px;">
            <?php echo $assunto ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding: 5px;font-weight: bold;text-align: center; border-top: 1px solid #EEE;">
            <?php echo $mensagem ?>
        </td>
    </tr>
    </tbody>
</table>
</body>