<?php 
error_reporting(E_ALL);
include('fpdf.php'); 
include('fpdi.php'); 

//Run the SQL and link the tables and get the specific data for this GCE filenumber

$gceno=$_POST["gceno"];

try {   

$db = new PDO('mysql:host=localhost;dbname=dbdownloader;charset=UTF-8', 'root', 'Passw0rd');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//$query = "SELECT * FROM `all flood certs`";
$query="Select
`all_flood_certs`.`Order_Received`,
`all_flood_certs`.`GCE_File`,
`all_flood_certs`.Borrower,
`all_flood_certs`.Seller,
`all_flood_certs`.`Street_Address`,
`all_flood_certs`.Town,
`all_flood_certs`.State,
`all_flood_certs`.County,
`all_flood_certs`.Customer_File_Number,
`all_flood_certs`.Community AS Chicken,
`all_flood_certs`.Community_Number,
all_flood_certs.Amount_Invoiced,
all_flood_certs.Panel_Number,
all_flood_certs.Panel_Date,
all_flood_certs.LOMA,
all_flood_certs.PNP,
all_flood_certs.Flood_Zone,
all_flood_certs.Date_Invoiced,
all_flood_certs.Comments,
all_flood_certs.MSA,
all_flood_certs.CT_Number,
`customer_list`.`Bank_Name`,
customer_list.Lender_ID,
`customer_list`.Address,
`customer_list`.`Address 2`,
`customer_list`.City,
`customer_list`.State,
`customer_list`.`Zip_Code`,
`customer_list`.Phone,
`customer_list`.Fax,
`customer_list`.Life_of_Loan,
customer_list.Num_of_Pgs,
`all_flood_certs`.Attn,
community.State_Code,
community.County_Code,
community.Participating,
community.Community,
community.CID,
community.County as comcounty,
community.State as comstate,
community.Flags,
community.MSA,
community.City_Code,
`all_flood_certs`.`Tax_Map_Lot`
FROM `all_flood_certs`
LEFT JOIN `customer_list` on `all_flood_certs`.Lender=`customer_list`.BankID
LEFT JOIN community on `all_flood_certs`.`Community_Number`=community.CID
WHERE `all_flood_certs`.`GCE_File`= ?";

//The PDO prepare the query to the database
$results = $db->prepare ($query);

}
catch(Exception $e) { 
echo 'Exception -> '; 
var_dump($e->getMessage()); }

//Give the database a parameter to use in the query
$results->bindParam(1, $gceno, PDO::PARAM_STR);

//Now execute the query, make it happen
$results->execute();


//Assign the variables with data from the SQL statement above as well as other data like todays date
$today = date("F j, Y"); 

//A while loop to assign all the variables

while ($row = $results->fetch(PDO::FETCH_ASSOC)) {

$recvd= $row["Order_Received"];
$gcefile=$row["GCE_File"];
$borrower=$row["Borrower"];
$seller=$row["Seller"];
$street=$row["Street_Address"];
$town=$row["Town"];
$state=$row["State"];
$county=$row["County"];
$chicken=$row["Chicken"];
$bankadd1=$row["Address"];
$bankadd2=$row["Address_2"];
$bankcity=$row["City"];
$bankstate=$row["State"];
$bankzip=$row["Zip_Code"];
$bankphone=$row["Phone"];
$bankfax=$row["Fax"];
$bankattn=$row["Attn"];
$bankname=$row["Bank_Name"];
$community=$row["Community"];
$taxmaplot=$row["Tax_Map_Lot"];
$customerfile=$row["Customer_File_Number"];
$comcid=$row["CID"];
$statecode=$row["State_Code"];
$countycode=$row["County_Code"];
$comcounty=$row["comcounty"];
$comstate=$row["comstate"];
$commnum=$row["Community_Number"];
$lenderid=$row["Lender_ID"];
$price=$row["Amount_Invoiced"];
$panel=$row["Panel_Number"];
$paneldate=$row["Panel_Date"];
$loma=$row["LOMA"];
$pnp=$row["PNP"];
$floodzone=$row["Flood_Zone"];
$participate=$row["Participating"];
$dateinvoiced=$row["Date_Invoiced"];
$life=$row["customer_list.Life_of_Loan"];
$flags=$row["Flags"];
$comments=$row["Comments"];
$floodmsa=$row["all_flood_certs.MSA"];
$communitymsa=$row["community.MSA"];
$citycode=$row["City_Code"];
$ctnumber=$row["CT_Number"];
$pages=$row["Num_of_Pgs"];
}
//Code explodes TaxMapLot
$pieces = explode("/", $taxmaplot);
$count = count($pieces);


// initiate FPDI 
$pdf =& new FPDI(); 



// set the sourcefile 
$pdf->setSourceFile('certnew.pdf'); 

// import page 1 of the source PDF
$tplIdx = $pdf->importPage(1); 
$specs = $pdf->getTemplateSize($tplIdx);

// add a page 
$pdf->AddPage($specs['h']>$specs['w']?'P':'L', array($specs['w'],$specs['h'])); 

// use the imported page as the template 
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

// now write some text above the imported page 
$pdf->SetFont('Times','',12); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetXY(54.9, 73); 
$pdf->Write(0, $bankname);
$pdf->SetXY(54.9, 77); 
$pdf->Write(0, $bankadd1);
IF ($bankadd2 != NULL) {
$pdf->SetXY(54.9, 81);
$pdf->Write(0, $bankadd2);
$pdf->SetXY(54.9, 85); 
$pdf->Write(0, $bankcity);
$pdf->Write(0, ", ".$bankstate);
$pdf->Write(0, " ".$bankzip);
}
ELSE { 
$pdf->SetXY(54.9, 81); 
$pdf->Write(0, $bankcity);
$pdf->Write(0, ", ".$bankstate);
$pdf->Write(0, " ".$bankzip);
}
$pdf->SetXY(54.9, 85); 
$pdf->Write(0, $bankphone);
$pdf->SetXY(54.9, 89); 
$pdf->Write(0, $bankfax);
$pdf->SetXY(132, 73); 
$pdf->Write(0, $bankattn);

//Lower front page invoice area
$pdf->SetXY(72,122.5);
$pdf->Write(0,$today);
$pdf->SetXY(72,138.75);
$pdf->Write(0, $borrower);
$pdf->SetXY(72,148);
$pdf->Write(0, $seller);
$pdf->SetXY(72,160);
$pdf->Write(0, $street);
$pdf->SetXY(72,164);
$pdf->Write(0, $town);
$pdf->Write(0, ", ".$state);
$pdf->Write(0, " ".$bankzip);
$pdf->SetXY(72,176.5);
$pdf->Write(0, $county);
$pdf->SetXY(72,186.5);
$pdf->Write(0, $bankname);
$pdf->SetXY(72,205.5);
$pdf->Write(0,$customerfile);
$pdf->SetXY(72, 214); 
$pdf->Write(0, $gcefile); 
$pdf->SetXY(36, 224.5); 
$pdf->Write(0, "PRICE:                      $".$price); 

//Page 2 starts here, Baby!
// import page 2 of the source PDF
$tplIdx = $pdf->importPage(2); 
$specs = $pdf->getTemplateSize($tplIdx);

// add a page 
$pdf->AddPage($specs['h']>$specs['w']?'P':'L', array($specs['w'],$specs['h'])); 

// use the imported page as the template 
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

// Text for Page 2 Lender Name
$pdf->SetXY(20, 36); 
$pdf->Write(0, $bankname);
$pdf->SetXY(20, 41); 
$pdf->Write(0, $bankadd1);

IF ($bankadd2 != NULL) {
$pdf->SetXY(20, 46);
$pdf->Write(0, $bankadd2);
$pdf->SetXY(20, 51); 
$pdf->Write(0, $bankcity);
$pdf->Write(0, ", ".$bankstate);
$pdf->Write(0, " ".$bankzip);
}
ELSE { 
$pdf->SetXY(20, 46); 
$pdf->Write(0, $bankcity);
$pdf->Write(0, ", ".$bankstate);
$pdf->Write(0, " ".$bankzip);
}
//TAX MAP
$pdf->SetXY(117, 41); 
$pdf->Write(0, $pieces[0]);

//TAX MAP AND LOT
IF ($count == 3){
$pdf->SetXY(133,41); 
$pdf->Write(0,$pieces[1]);
$pdf->SetXY(155,41);
$pdf->Write(0,$pieces[2]);
}ELSE{
$pdf->SetXY(155,41); 
$pdf->Write(0,$pieces[1]);
}

$pdf->SetXY(101,47);
$pdf->Write(0, $street);
$pdf->SetXY(101,52);
$pdf->Write(0, $town);
$pdf->Write(0, " ".$bankzip);
$pdf->Write(0, ", ".$state);
$pdf->SetXY(22,71);
$pdf->Write(0,$lenderid);

//LOAN IDENTIFIER
If (empty($customerfile)){
$pdf->SetXY(95,71);
$pdf->Write(0,"NA");
echo 'NA';
}
Else { 
$pdf->SetXY(95,71);
$pdf->Write(0,$customerfile);
}


//NFIP COMMUNITY NAME
IF ($comcid == "NO COMMUNITY NUMBER"){
$pdf->SetXY(40,90);
$pdf->Write(0,$town);
$pdf->SetFont('Times','',12); 
}ELSE{
$pdf->SetXY(50,87);
$pdf->Write(0,$community);
}

//COUNTIES
IF ($comcid == "NO COMMUNITY NUMBER"){
$pdf->SetXY(96,87);
$pdf->Write(0,$county);
$pdf->SetFont('Times','',12); 
}ELSE{
$pdf->SetXY(96,87);
$pdf->Write(0,$comcounty);
}

//STATE
IF ($comcid == "NO COMMUNITY NUMBER"){
$pdf->SetXY(122,87);
$pdf->Write(0,$state);
$pdf->SetFont('Times','',12); 
}ELSE{
$pdf->SetXY(122,87);
$pdf->Write(0,$comstate);
}

//NFIP COMMUNITY NUMBER
IF ($commnum == "NO COMMUNITY NUMBER"){
$pdf->SetXY(154,87);
$pdf->Write(0,"NO COMMUNITY NUMBER");
$pdf->SetFont('Times','',12); 
}ELSE{
$pdf->SetXY(154,87);
$pdf->Write(0,$commnum);
}

$pdf->SetXY(44,108);
$pdf->Write(0,$panel);

$pdf->SetXY(105,108);
$pdf->Write(0,$paneldate);

//LOMA checkbox
If ($loma != NULL){
$pdf->SetXY(137.5,106.75);
$pdf->SetFont('Times','',6); 
$pdf->Write(0,"X");}
Else{}

//LOMA Date
IF ($loma != NULL){
$pdf->SetXY(140.5,109.75);
$pdf->SetFont('Times','',9); 
$pdf->Write(0,$loma);}
ELSE{}

//Flood Zone
$pdf->SetXY(175,108);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$floodzone);

//PNP
$pdf->SetXY(195,108);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$pnp);

//Participating
IF ($participate == "yes"){
$pdf->SetXY(11.25,120);
$pdf->Write(0,"X");}
ELSE{
$pdf->SetXY(11.25,125);}


//Regular Program
IF (($participate == "yes") && ((is_null($flags)) || ($flags =="L") || ($flags =="M") || ($flags =="NSFHA") ||  ($flags =="S"))){
$pdf->SetXY(110.5,120);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{}

//Emergency
IF ($flags == "E"){
$pdf->SetXY(148.5, 120);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{}

//Special Flood Hazard Area YES
IF ((substr($floodzone,0,1) == 'A') || (substr($floodzone,0,1) == 'V') || (substr($floodzone,0,1) == 'D')){
$pdf->SetXY(130, 156.75);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{
$pdf->SetXY(153, 156.75);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}

//Determination Number
$pdf->SetXY(145,178.5);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$gcefile);

//Comments
$pdf->SetXY(153, 12);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$comments);

//Certify To
$pdf->SetXY(32,203);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$bankname);

//Life of Loan
IF ($life != "YES"){
$pdf->SetXY(155,203);
$pdf->SetFont('Times','',9); 
$pdf->Write(0,"N/A");}
ELSE{
$pdf->SetXY(155,203);
$pdf->SetFont('Times','',9); 
$pdf->Write(0,"LIFE OF LOAN");}

//State Code
$pdf->SetXY(43,208.75);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$statecode);

//County Code
$pdf->SetXY(80,208.75);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$countycode);

//Date Invoiced
$pdf->SetXY(130,235);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$dateinvoiced);

//MSA
IF ($communitymsa != NULL){
$pdf->SetXY(135.5,208.5);
$pdf->Write(0,$communitymsa);}
ELSE
{IF ($floodmsa == NULL){
$pdf->SetXY(135.5,208.5);
$pdf->Write(0,"N/A");} ELSE {}}

//CITY
IF ($citycode == NULL){
$pdf->SetXY(175.5,208.5);
$pdf->Write(0,$ctnumber);}
ELSE{
$pdf->SetXY(175.5,208.5);
$pdf->Write(0,$citycode);
}


//CREATING PAGE 3
IF(($pages == 3) || ($pages == 4)){
// import page 3 of the source PDF
$tplIdx = $pdf->importPage(3); 
$specs = $pdf->getTemplateSize($tplIdx);

// add a page 
$pdf->AddPage($specs['h']>$specs['w']?'P':'L', array($specs['w'],$specs['h'])); 

// use the imported page as the template 
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

//Borrower
$pdf->SetXY(28,13.5);
$pdf->SetFont('Times','',8); 
$pdf->Write(0,$borrower);

//Street Address
$pdf->SetXY(28,17.5);
$pdf->SetFont('Times','',8); 
$pdf->Write(0,$street);

//PROPERTY ADDRESS
IF ($bankzip != NULL) {
$pdf->SetXY(28, 21.5); 
$pdf->Write(0, $town);
$pdf->Write(0, ", ".$state);
$pdf->Write(0, " ".$bankzip);
}
ELSE { 
$pdf->SetXY(28, 19.5); 
$pdf->Write(0, $town);
$pdf->Write(0, ", ".$state);
$pdf->Write(0, " ".$bankzip);
}
//PROPERTY ADDRESS


//Lender
$pdf->SetXY(30.5,26.25);
$pdf->SetFont('Times','',8); 
$pdf->Write(0,$bankname);

//Determination Number
$pdf->SetXY(160,13.5);
$pdf->SetFont('Times','',8); 
$pdf->Write(0,$gcefile);

//Flood Zone
$pdf->SetXY(145,22);
$pdf->SetFont('Times','',8); 
$pdf->Write(0,$floodzone);

//Borrower in Special Flood
IF ((substr($floodzone,0,1) == 'A') || (substr($floodzone,0,1) == 'V') || (substr($floodzone,0,1) == 'D')){
$pdf->SetXY(7, 33.50);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{
$pdf->SetXY(7, 33.50);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}

//Borrower Notice to Purchase Flood Insurance
IF ((substr($floodzone,0,1) == 'A') || (substr($floodzone,0,1) == 'V') || (substr($floodzone,0,1) == 'D')){
$pdf->SetXY(7, 75.5);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{
$pdf->SetXY(7, 75.5);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}

//Borrower Flood Disaster Assistance
IF (($participate == "yes") && ((is_null($flags)) || ($flags =="L") || ($flags =="M") || ($flags =="NSFHA") || ($flags =="E") || ($flags =="S"))){
$pdf->SetXY(7.75,99.25);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{}

//Notice in Non-Participating Communities
IF (($participate == "no")){
$pdf->SetXY(7.75,165);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"X");
}ELSE{}

//Community Name
$pdf->SetXY(7.75,215);
$pdf->SetFont('Times','',8); 
$pdf->Write(0,$community);

//Status
IF (($participate == "no")){
$pdf->SetXY(45,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"Not Participating");
}ELSE{
$pdf->SetXY(45,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"Participating");}

//Program
IF (($participate == "yes") && ((is_null($flags)) || ($flags =="L") || ($flags =="M") || ($flags =="NSFHA") || ($flags =="E") || ($flags =="S"))){
$pdf->SetXY(80,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"Regular");
}ELSE IF(($Flags == "E")){
$pdf->SetXY(80,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"Emergency");
}ELSE{}

//NFIP Community
IF ($comcid == "NO COMMUNITY NUMBER"){
$pdf->SetXY(107,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"NO COMMUNITY NO.");
}ELSE{
$pdf->SetXY(107,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,$comcid);
}

//FEMA Map Panel
IF ($panel == "NO PANEL NUMBER"){
$pdf->SetXY(150,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,"NO PANEL NO.");
}ELSE{
$pdf->SetXY(150,215);
$pdf->SetFont('Times','',10);
$pdf->Write(0,$panel);
}

//DATE
$pdf->SetXY(170,215);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$paneldate);

}
ELSE {
}

//CREATING PAGE 4
IF(($pages == 3) || ($pages == 4)){
// import page 4 of the source PDF
$tplIdx = $pdf->importPage(4); 
$specs = $pdf->getTemplateSize($tplIdx);

// add a page 
$pdf->AddPage($specs['h']>$specs['w']?'P':'L', array($specs['w'],$specs['h'])); 

// use the imported page as the template 
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

//Bank Name
$pdf->SetXY(25,35);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$bankname);

//Bank Address
IF ($bankadd2 != NULL) {
$pdf->SetXY(25, 40);
$pdf->Write(0, $bankadd2);
$pdf->SetXY(25, 40); 
$pdf->Write(0, $bankcity);
$pdf->Write(0, ", ".$bankstate);
$pdf->Write(0, " ".$bankzip);
}
ELSE { 
$pdf->SetXY(25, 40); 
$pdf->Write(0, $bankcity);
$pdf->Write(0, ", ".$bankstate);
$pdf->Write(0, " ".$bankzip);
}

//Borrower
$pdf->SetXY(110,34.5);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$borrower);

//Street Address
$pdf->SetXY(110,39.25);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$street);

//Property Address
$pdf->SetXY(110,43);
$pdf->Write(0, $town);
$pdf->Write(0, ", ".$state);

//GCE File
$pdf->SetXY(120,54.5);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$gcefile);

//Customer File Number
$pdf->SetXY(120,57.5);
$pdf->SetFont('Times','',10); 
$pdf->Write(0,$customerfile);

//Now output to the PDF file
$pdf->Output($gceno.'.pdf', 'D'); 

}
ELSE{
}

?>