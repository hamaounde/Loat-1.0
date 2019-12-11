<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use DateTime;
use App\numero;
use Illuminate\Support\Facades\DB;
class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //



        // $numero = DB::table('numeros');
        $numero = numero::orderBy('numero', 'desc')->value('numero');
        $numero_courant = $numero + 1;

        $date_facture = date('d/m/y');
        $numero_facture = $request->numero_facture;
        $departement = 'Division 777';
        $interlocuteur = $request->interlocuteur;
        $mobile = $request->mobile;
        $email = $request->email;
        $client = $request->client;
        $designation = $request->designation;
        $quantite = $request->quantite;
        $jour = $request->jour;
        $periodeDebut = $request->periodeDebut;
        $periodeFin = $request->periodeFin;
        $forfait = $request->forfait;


        $ht = $request->ht;
        $tva =  $request->tva;
        $ttc = $request->ttc;


        $depart = $request->depart;
        $destination = $request->destination;
        $heureDepart = $request->heureDepart;
        $heureArrive = $request->heureArrive;

            // return $periodeDebut;

        $totalNetLettre = $request->totalNetLettre;

        $pdf = \App::make('dompdf.wrapper');

        $item = new numero;
        $item->numero = $numero_courant;
        $item->save();

        $pdf->loadHTML($this->convert_customer_data_to_html($numero_courant,$date_facture, $numero_facture, $departement,
                    $interlocuteur, $mobile, $email, $client, $periodeDebut, $periodeFin,
                    $designation, $depart, $destination, $quantite, $jour,
                    $forfait, $ht, $tva, $ttc,$totalNetLettre));
        return $pdf->stream();
    }

    private function convert_customer_data_to_html($numero_courant,$date_facture, $numero_facture, $departement, $interlocuteur, $mobile, $email, $client,  $periodeDebut, $periodeFin, $designation, $depart, $destination, $quantite, $jour, $forfait, $ht, $tva, $ttc, $totalNetLettre){


        $month = date('m');
        $year = date('y');
        $total = $forfait * $quantite * $jour;
        $numero_final= "";
        if($numero_courant < 10 ){
            $numero_final = "00". $numero_courant ;
        }elseif($numero_courant >=10 && $numero_courant < 100){
            $numero_final = "0" . $numero_courant;
        }
        $output = ' <h5>FACTURE PROFORMA</h5>
                    <p>Date de la facture: '. $date_facture . ' <br>
                    N° ' . $numero_final. '/TE/DIV777/'. $month. '/'.$year. ' <br>
                    Département: ' .$departement. ' <br>
                    Interlocuteur: ' .$interlocuteur. ' <br>
                    Mobile: '.$mobile.' <br>
                    Email: '.$email.' <br></p>
                    <div style="background-color:#e0e0e0;"><h5 style="margin-left:600px; ">CLIENT</h5></div>
                    <div style="margin-top:-35px;background-color:#e0e0e0;"><h5 style="margin-left:600px; ">'. $client. '</h5></div>
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                    <tr style="padding: 5px;">
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Désignations</th>
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Quantité</th>
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Jour(s)</th>
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Itinéraire</th>
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Période</th>
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Forfait </th>
                        <th style="padding: 5px;text-align: left; border: 1px solid black;border-collapse: collapse;">Total</th>
                    </tr>
                    <tr>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">Location  Autobus avec chauffeurs <br>
                        <u>Caractéristiques véhicule </u> <br>
                            -	Confort <br>
                            -	49 places <br>
                            -	Climatisation <br>
                            -	Ceintures de sécurité <br>
                            -	DVD
                        </td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'. $quantite .'</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'.$jour. '</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">' .$depart .'<br>' .$destination.'</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;"> '.$periodeDebut.' <br> '.$periodeFin.'</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'. $forfait.'</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'. $total. '</td>
                    </tr>
                    </table> <br> <br>
                    <ul style="list-style-type:none; border: 1px solid black; width:50%; margin-left:44%">
                        <li>Montant HT : '.$ht. '</p>
                        <li>TVA 19.25% :  '.$tva. '</p>
                        <li>Montant net TTC : '.$ttc.'</p>
                    </ul>
                    <h5>Total net en lettres</h5>
                    <p>Arrêté la présente facture à la somme de '. $totalNetLettre. ' CFA TTC.</p>
                    </table> <br> <br>
                    <ul style="list-style-type:none; border: 1px solid black; width:78%;">
                        <li>Conditions :</p>
                        <li>Règlement avant la prestation : Espèces, chèque, ou virement bancaire. <br>
                        Carburant et péage à la charge de TOURISTIQUE EXPRESS</li>
                        <li>Compte N° 10002 00031 12211603150 17</li>
                        <li>Banque : SCB</li>
                        <li>Régime d’imposition : REEL</li>
                    </ul>
                    <div style="margin-left:85%"><u> La Direction</u></div>
                    ';

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
