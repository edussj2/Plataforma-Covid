<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{	
	protected $B = 0;
	protected $I = 0;
	protected $U = 0;
	protected $HREF = '';
	function WriteHTML($html)
	{
	    // Intérprete de HTML
	    $html = str_replace("\n",' ',$html);
	    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	    foreach($a as $i=>$e)
	    {
	        if($i%2==0)
	        {
	            // Text
	            if($this->HREF)
	                $this->PutLink($this->HREF,$e);
	            else
	                $this->Write(8,$e);
	        }
	        else
	        {
	            // Etiqueta
	            if($e[0]=='/')
	                $this->CloseTag(strtoupper(substr($e,1)));
	            else
	            {
	                // Extraer atributos
	                $a2 = explode(' ',$e);
	                $tag = strtoupper(array_shift($a2));
	                $attr = array();
	                foreach($a2 as $v)
	                {
	                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
	                        $attr[strtoupper($a3[1])] = $a3[2];
	                }
	                $this->OpenTag($tag,$attr);
	            }
	        }
	    }
	}

	function OpenTag($tag, $attr)
	{
	    // Etiqueta de apertura
	    if($tag=='B' || $tag=='I' || $tag=='U')
	        $this->SetStyle($tag,true);
	    if($tag=='A')
	        $this->HREF = $attr['HREF'];
	    if($tag=='BR')
	        $this->Ln(5);
	}

	function CloseTag($tag)
	{
	    // Etiqueta de cierre
	    if($tag=='B' || $tag=='I' || $tag=='U')
	        $this->SetStyle($tag,false);
	    if($tag=='A')
	        $this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
	    // Modificar estilo y escoger la fuente correspondiente
	    $this->$tag += ($enable ? 1 : -1);
	    $style = '';
	    foreach(array('B', 'I', 'U') as $s)
	    {
	        if($this->$s>0)
	            $style .= $s;
	    }
	    $this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
	    // Escribir un hiper-enlace
	    $this->SetTextColor(0,0,255);
	    $this->SetStyle('U',true);
	    $this->Write(5,$txt,$URL);
	    $this->SetStyle('U',false);
	    $this->SetTextColor(0);
	}
	// Cabecera de página
	function Header()
	{
	    // Logo ruta/x/y/ancho/Alto
	    $this->Image('../vistas/assets/iconos/logoUnprg.png',160,10,35,0,'','www.plataformaCovidUnprg.org');
	    // Arial bold 15
	    $this->SetFont('Arial','B',19);
	    // Movernos a la derecha
	    $this->Cell(18);
	    // Título ancho,alto,texto, border
	    $this->Cell(120,20,utf8_decode('PLATAFORMA COVID-19'),0,0,'C');
	   	// Salto de línea
	    $this->Ln(15);
	    // Arial bold 14
	    $this->SetFont('Arial','I',16);
	    // Movernos a la derecha
	    $this->Cell(52);
	    // Título ancho,alto,texto, border
	    $this->Cell(50,10,utf8_decode('Universidad Pedro Ruiz Gallo'),0,0,'C');
	    // Salto de línea
	    $this->Ln(10);
	    // Movernos a la derecha
	    $this->Cell(14);
	    // Título ancho,alto,texto, border
	    $this->Cell(128,0,'',1,0,'C');
	    // Salto de línea
	    $this->Ln(10);
	}
}

require "../config/configDB.php";
function decryption($string){
	$key=hash('sha256', SECRET_KEY);
	$iv=substr(hash('sha256', SECRET_IV), 0, 16);
	$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
	return $output;
}

$id = $_GET['numero'];
$id = decryption($id);
	
$conexion = new PDO(SGBD,USER,PASS);

	/*CONSULTA*/
	$consulta = "SELECT U.UsuarioNombres AS nombres, U.UsuarioApellidoPaterno AS paterno, U.UsuarioApellidoMaterno AS materno, U.UsuarioTipo AS tipo, U.UsuarioNacimiento AS nacimiento, U.UsuarioFoto AS foto, U.UsuarioTelefono AS celular, C.CuentaCorreo AS email, C.CuentaAvatar AS avatar, D.	DiagnosticoDescripcion	AS diag
	FROM usuario AS U 
	INNER JOIN cuenta AS C ON C.CuentaCodigo = U.CuentaCodigo
	INNER JOIN atencion AS A ON A.idUsuario = U.idUsuario
	INNER JOIN diagnostico AS D ON D.idAtencion = A.idAtencion
	WHERE D.idAtencion ='$id'";

/**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
$resultado = $conexion->query($consulta);
$row = $resultado->fetch();

if($resultado->rowCount()>=1){
	//PASAR A ESPAÑOL LA FECHA ACTUAL
	function actual_date ()  
	{  
	    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
	    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
	    $year_now = date ("Y");  
	    $month_now = date ("n");  
	    $day_now = date ("j");  
	    $week_day_now = date ("w");  
	    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
	    return $date;    
	} 
	$fecha = actual_date();

	//TEXTO FIJO EN LAS CONSTANCIAS 
	$html = 'Nombre: <b>'.$row['nombres'].' '.$row['paterno'].' '.$row['materno'].'</b><br><br><i>Tipo:</i> <b>'.$row['tipo'].'</b><br><br><i>Correo:</i> <b>'.$row['email'].'</b><br><br><i>Celular:</i> <b>'.$row['celular'].'</b><br><br><i>Fecha de nacimiento:</i> <b>'.$row['nacimiento'].'</b>';



	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$header = array('Datos de colegiatura');
	//FECHA ACTUAL
	// Movernos a la derecha
	$pdf->Cell(120);
	$pdf->SetFont('Arial','I',11);
	// Título ancho,alto,texto, border
	$pdf->Cell(70,10,utf8_decode($fecha),0,0,'C');
	// Salto de línea
	$pdf->Ln(10);

	if($row['foto'] != "nulo"){
		//ruta/x/y/ancho/Alto
		$pdf->Image('../adjuntos/usuarios/'.$row['foto'],25,56,40,46);

		//TEXTO FIJO
		$pdf->SetLeftMargin(72);
		$pdf->SetFontSize(14);
		$pdf->WriteHTML(utf8_decode($html));
		// Salto de línea
		$pdf->Ln(17);
	}else{
		$pdf->Image('../vistas/assets/avatars/'.$row['avatar'],25,56,40,46);
		//TEXTO FIJO
		$pdf->SetLeftMargin(72);
		$pdf->SetFontSize(14);
		$pdf->WriteHTML(utf8_decode($html));
		// Salto de línea
		$pdf->Ln(17);
	}

	$html2 = '<p>'.$row['diag'].'</p>';
	//COLEGIATURA
	$pdf->SetFont('Arial','B',17);
	$pdf->Cell(-48);
	$pdf->Cell(65,10,utf8_decode('Datos del Diagnóstico'),0,0,'C');
	$pdf->Ln(12);
	$pdf->SetFont('Arial','I',13);
	$pdf->Cell(-50);
	$pdf->SetLeftMargin(18);
	$pdf->SetFontSize(14);
	$pdf->WriteHTML(utf8_decode($html2));
	// Salto de línea
	$pdf->Ln(17);
	
	
}else{
	$i = "Hubo problemas para encontrar su información";
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();

	//CONSTANCIA Y NOMBRE
	// Arial bold 15
	$pdf->SetFont('Arial','B',15);
	// Movernos a la derecha
	$pdf->Cell(40);
	// Título ancho,alto,texto, border
	$pdf->Cell(120,10,utf8_decode($i),0,0,'C');
	// Salto de línea
	$pdf->Ln(12);
}

$pdf->Output();
?>