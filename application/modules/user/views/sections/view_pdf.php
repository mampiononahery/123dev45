<!DOCTYPE html>
<html lang="fr">
<head>
    <title>pdf</title>
    <meta charset='utf-8'>
    <style type="text/css">
        #tableau {
            border-width: 1px;
            border-style: solid;
            border-color: black;
            margin: auto;
        }

        #tableau th {
            background-color: rgba(153, 153, 153, 0.6)
        }

         #tableau  td {
            padding: 5px;
        }

        .pair {
            background-color: white;
        }

        .impair {
            background-color: rgba(153, 153, 153, 0.2);
        }

        #date {
            font-family: arial;
            font-size: 12px;
            font-weight: normal;
            border-bottom: 2px solid #232a2f;
            margin-top: 1px;

        }
    </style>
</head>
<body>

<div id="entete">
   
    <?php $date_valeur = $prod[0]->dt_start;
			$val1 = explode(" ",$date_valeur );
			
			$d_en = explode("-",$val1[0]);
			
			$d_f = $d_en[2]."/".$d_en[1]."/".$d_en[0];
			
			
	
	
	
	?>
   
   
   
	<table>
		<tr>
		    <td width="100%">
			
				<p><?php echo $user->nom_societe; ?></p>
				<p><?php echo $user->adresse; ?> </p>
				<p><?php echo $user->code_postal; ?> <?php echo $user->ville; ?> </p>
				<p><?php echo $user->code_postal; ?> <?php echo $user->pays; ?>  </p>
			
			</td>
			 <td>
				Facture No.<?php echo rand(10,100); ?>
			</td>
		
		</tr>
		<tr>
		    <td>
			
				<p>Date de la facture	: <?php echo date("d/m/Y"); ?>
				</p>
				<p>Référence de la facture	 : <?php echo $client->client_id."".date("Ymd"); ?></p>
				<p>Numéro de client : 	<?php echo $client->client_id ?></p>
				<p>Date de la vente/prestation	: <?php echo $d_f; ?></p>





			
			</td>
			 <td>
				<p>Destinataire : <p>
				<p><?php echo $client->nom." ".$client->prenom  ;?></p>
				<p><?php echo $client->ville.",";$client->cp   ;?></p>
				<p><?php echo $client->adresse  ;?></p>
				<p><?php echo $client->tel_mobile  ;?></p>
				<p><?php echo $client->tel_fixe  ;?></p>
			</td>
		
		</tr>
	
	
	</table>

    

</div>

<table id="tableau" style="margin-top:20px;">
    <thead style="align: 'center'">
    <tr>
	
		<th width="250px">Description</th>
		<th width="100px">Quantites</th>
		<th width="100px">Unites</th>
		<th width="100px">Prix unitaires HT</th>
		<th width="100px">% TVA</th>
		<th width="100px">TVA</th>
		<th width="100px">TOTAL TTC</th>
       
    </tr>
    </thead>
    <tbody>

	
			<?php $somme_tva = 0; ?>
			<?php foreach($prod as $p) { ?>
				<tr>
				<td><?php echo $p->prod_label  ;?></td>
				<td><?php echo $p->qte   ;?></td>
				<td>Euro</td>
				<td><?php echo number_format($p->prix,2,',',' ')  ;?></td>
				<td>20 % </td>
				
				<?php
					$tva = ($p->prix*20)/100;
					$somme_tva = $somme_tva + $tva;
				?>
				<td><?php echo number_format($tva,2,',',' '); ?></td>
				
				
				<td><?php echo number_format(($p->prix + $tva),2,',',' ')  ;?></td>
				  </tr>
			<?php } ?>
			
			
		
    </tbody>
</table>

			<div style="text-align:right;margin-top:20px;">
				<strong>TOTAL HT :</strong> <strong><?php echo number_format($total,2,',',' ')  ;?></strong>
			</div>
			<div style="text-align:right;border-bottom: 2px solid #232a2f;">
				<strong>TVA :</strong> 
				<strong><?php echo number_format($somme_tva,2,',',' ')  ;?></strong>
			</div>
			<div style="text-align:right;">
				<strong>Total TTC :</strong>
				<strong><?php echo number_format(($somme_tva +$total) ,2,',',' ')  ;?></strong>
			</div>
			
<div style="margin-bottom:0px;margin-top: 50px;">			
	<table>
		<tr>
			<td width="100%">
			
				<p><?php echo $user->nom_societe; ?></p>
				<p><?php echo $user->adresse; ?></p>
				<p><?php echo $user->code_postal; ?> <?php echo $user->ville; ?></p>

				<p><?php echo $user->pays; ?></p>

				<p><?php echo $user->siren; ?> </p>

				<p><?php echo $user->n_tva; ?></p>
			
			</td>
			<td>
				<p>Details bancaire: </p>
				<p>Banque : <?php echo $user->nom_banque; ?> </p>
				<p>IBAN : <?php echo $user->iban; ?> </p>

				<p>SWIFT : <?php echo $user->swift; ?></p>

				 
			</td>
		
		</tr>
	</table>
</div>
		

</body>
</html>
