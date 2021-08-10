<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Home</title>
</head>
<body>

<?php
  include('../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../index.php">Home</a>
  <a href="../api/person/read.php">Person</a>
  <a href="#">Public Health Worker</a>
  <a href="#">Public Health Facility</a>
  <a href="#">Vaccination Type</a>
  <a href="#">COVID-19 Variants</a>
  <a href="#">Age Groups</a>
  <a href="#">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="#">Perform Vaccine</a>
  <a href="other_query_UI.php">Other Query</a>
</div>

<div class="main">

<dl style='font-size: 20px'>
    <dt> <b> Click on one of the queries to perform: </b> </dt>
    <a href="query_12.php"> <dd> (12) Get details of all the people who got vaccinated only one dose and are of group ages 1 to 3 (first-name, last-name, date of birth, email, phone, city, date of vaccination, vaccination type, been infected by COVID-19 before or not).</dd> </a> 
    <dd> (13) Get details of all the people who live in the city of Montréal and who got vaccinated at least two doses of different types of vaccines. (First name, last name, date of birth, email, phone, city, date of vaccination, vaccination type, been infected by COVID-19 before or not). </dd>
    <dd> (14) Get details of all the people who got vaccinated and have been infected with at least two different variants of Covid-19 (first-name, last-name, date of birth, email, phone, city, date of vaccination, vaccination type, number of times being infected by COVID-19 variants)</dd>
    <dd> (15) Give a report of the inventory of vaccines in each province. The report should include for each province and for each type of vaccine, the total number of vaccines available in the province. The report should be displayed in ascending order by province then by descending order of number of vaccines in the inventory</dd>
    <dd> (16) Give a report of the population’s vaccination by province between January 1st2021 and July 22nd 2021. The report should include for each province and for each type of vaccine, the total number of people using the type of vaccine. If a person have been vaccinated with Pfizer twice then the person will be counted only once for Pfizer. But if a person have been vaccinated one dose for Pfizer and one dose for Moderna then the person is counted once for each type.</dd>
    <dd> (17) Give a report by city in Québec the total number of vaccines received in each city between January 1st 2021 and July 22nd 2021.</dd>
    <dd> (18)  Give a detailed report of all the facilities in the city of Montréal. The report should include the name, address, type and phone number of the facility, the total number of public health workers working in the facility, the total number of shipments of vaccines received by the facility, the total number of doses received by the facility, the total number of transfer of vaccines from the facility and transfer to the facility, the total number of doses transferred from the facility, the total number of doses transferred to the facility, the total number of vaccines of each type in the facility, the number of people vaccinated in the facility, and the number of doses people have received in the facility. </dd>
    <dd> (19) Give a list of all public health workers in a specific facility (EmployeeID, Social Security Number (SSN), first-name, last-name, date of birth, medicare card number, telephone-number, address, city, province, postal-code, citizenship, email address, and history of employment).</dd>
    <dd> (20) Give a list of all public health workers in Québec who never been vaccinated or who have been vaccinated only one dose for Covid-19 (EmployeeID, first-name, last-name, date of birth, telephone-number, city, email address, locations name where the employee work). </dd>

</dl>
</div>
</body>
</html>