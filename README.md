# Distance Calculator
## Requirements
- PHP 8.1 or higher
- Symfony CLI version 5.5.7 or higher
- Composer 2.5 or higher

## Installation

- Run `composer install`

## Calculate Distances
Run `php bin/console distance:calculator`

## Run PhpUnits
Run `php bin/phpunit tests/`

## Sample Output 
Print in Console
```

HeadQuarter Distances
=====================

HeadQuarter
 ------------- --------------------------------------------------------------- 
  Name          Address                                                        
 ------------- --------------------------------------------------------------- 
  Adchieve HQ   Sint Janssingel 92, 5211 DA 's-Hertogenbosch, The Netherlands  
 ------------- --------------------------------------------------------------- 

Places
 ------------ ------------ --------------------------- ------------------------------------------------------------------------------------------------------------------------------------------- 
  Sortnumber   Distance     Name                        Address                                                                                                                                    
 ------------ ------------ --------------------------- ------------------------------------------------------------------------------------------------------------------------------------------- 
  1            62.59 km     Adchieve Rotterdam          Weena 505, 3013 Rotterdam, The Netherlands                                                                                                 
  2            120.45 km    Eastern Enterprise B.V.     Deldenerstraat 70, 7551AH Hengelo, The Netherlands                                                                                         
  3            377.22 km    Sherlock Holmes             221B Baker St., London, United Kingdom                                                                                                     
  4            549.4 km     The Pope                    Saint Martha House, 00120 Citta del Vaticano, Vatican City                                                                                 
  5            5915.57 km   The Empire State Building   350 Fifth Avenue, New York City, NY 10118                                                                                                  
  6            6243.3 km    The White House             1600 Pennsylvania Avenue, Washington, D.C., USA                                                                                            
  7            6636.85 km   Eastern Enterprise          46/1 Office no 1 Ground Floor , Dada House , Inside dada silk mills compound, Udhana Main Rd, near Chhaydo Hospital, Surat, 394210, India  
  8            9043.15 km   Neverland                   5225 Figueroa Mountain Road, Los Olivos, Calif. 93441, USA                                                                                 
 ------------ ------------ --------------------------- ------------------------------------------------------------------------------------------------------------------------------------------- 
```
Generates `distances.csv` file in project Data directory.(commited for reviewing purpose only.)
```
Sortnumber,Distance,Name,Address
1,"62.59 km","Adchieve Rotterdam","Weena 505, 3013 Rotterdam, The Netherlands"
2,"120.45 km","Eastern Enterprise B.V.","Deldenerstraat 70, 7551AH Hengelo, The Netherlands"
3,"377.22 km","Sherlock Holmes","221B Baker St., London, United Kingdom"
4,"549.4 km","The Pope","Saint Martha House, 00120 Citta del Vaticano, Vatican City"
5,"5915.57 km","The Empire State Building","350 Fifth Avenue, New York City, NY 10118"
6,"6243.3 km","The White House","1600 Pennsylvania Avenue, Washington, D.C., USA"
7,"6636.85 km","Eastern Enterprise","46/1 Office no 1 Ground Floor , Dada House , Inside dada silk mills compound, Udhana Main Rd, near Chhaydo Hospital, Surat, 394210, India"
8,"9043.15 km",Neverland,"5225 Figueroa Mountain Road, Los Olivos, Calif. 93441, USA"
```
