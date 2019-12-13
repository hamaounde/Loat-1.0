<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use DateTime;
use App\numero;
use App\location;
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
        $locations = location::orderBy('id', 'asc')->paginate(10);
        return view('pages.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $number = location::orderBy('numero', 'desc')->value('numero');
        $numero_courant = $number + 1;
        $numero_final = "";
        if ($numero_courant < 10) {
            $numero_final = "00" . $numero_courant;
        } elseif ($numero_courant >= 10 && $numero_courant < 100) {
            $numero_final = "0" . $numero_courant;
        }


        $date_facture = date('d/m/y');

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
        $nbrePlace = $request->nbrePlace;

        $depart = $request->depart;
        $destination = $request->destination;
        if ($designation =="") {
            # code...
            $designation = "Location  Autobus avec chauffeurs ";
        }

        $heureDepart = $request->heureDepart;
        $heureArrive = $request->heureArrive;



        $totalNetLettre = $request->totalNetLettre;
        $month = date('m');
        $year = date('y');

        $sucess = $this->enregistrer($numero_courant, $date_facture, $departement, $interlocuteur, $mobile, $email, $client,  $periodeDebut, $periodeFin, $designation, $depart, $destination, $quantite, $jour, $forfait, $ht, $tva, $ttc, $totalNetLettre,  $nbrePlace, $heureDepart, $heureArrive);
        return redirect('/')->with('success', 'Votre facture est ajoutée');
    }

    private function convert_customer_data_to_html($month, $year, $numero_courant,$date_facture, $departement, $interlocuteur, $mobile, $email, $client,  $periodeDebut, $periodeFin, $designation, $depart, $destination, $quantite, $jour, $forfait, $ht, $tva, $ttc, $totalNetLettre,  $nbrePlace, $heureDepart, $heureArrive){


        $total = $forfait * $quantite * $jour;
        $output = ' <h5>FACTURE PROFORMA</h5>
                    <p>Date de la facture: '. $date_facture . ' <br>
                    N° ' . $numero_courant. '/TE/DIV777/'. $month. '/'.$year. ' <br>
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
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'. $designation.'<br>
                            <u>Caractéristiques véhicule </u> <br>
                            -	Confort <br>
                            -	'. $nbrePlace .'places <br>
                            -	Climatisation <br>
                            -	Ceintures de sécurité <br>
                            -	DVD
                        </td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'. $quantite .'</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">'.$jour. '</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;">' .$depart .'<br>' .$destination.'</td>
                        <td style="padding: 5px; border: 1px solid black;border-collapse: collapse;"> '.$periodeDebut.' <br> '.$periodeFin.' <br> '.$heureDepart.' - '.$heureArrive.' </td>
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


    private function enregistrer($numero_courant, $date_facture, $departement, $interlocuteur, $mobile, $email, $client,  $periodeDebut, $periodeFin, $designation, $depart, $destination, $quantite, $jour, $forfait, $ht, $tva, $ttc, $totalNetLettre,  $nbrePlace, $heureDepart, $heureArrive){
        $location = new location;
        $location->numero = $numero_courant;
        $location->date_facture = $date_facture;
        $location->departement = $departement;
        $location->interlocuteur = $interlocuteur;
        $location->mobile = $mobile;
        $location->email = $email;
        $location->client = $client;
        $location->periodeDebut = $periodeDebut;
        $location->periodeFin = $periodeFin;
        $location->designation = $designation;
        $location->destination = $destination;
        $location->depart = $depart;
        $location->quantite= $quantite;
        $location->jour= $jour;
        $location->forfait= $forfait;
        $location->ht= $ht;
        $location->tva= $tva;
        $location->ttc= $ttc;
        $location->totalNetLettre= $totalNetLettre;
        $location->nbrePlace= $nbrePlace;
        $location->heureDepart= $heureDepart;
        $location->heureArrive= $heureArrive;
        $location->save();

        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
        $locations = location::find($id);
        $month = date('m');
        $year = date('y');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html(
            $month,
            $year,
            $numero_final = $locations->numero,
            $date_facture = $locations->date_facture,
            $departement = $locations->departement,
            $interlocuteur = $locations->interlocuteur,
            $mobile = $locations->mobile,
            $email = $locations->email,
            $client = $locations->client,
            $periodeDebut = $locations->periodeDebut,
            $periodeFin = $locations->periodeFin,
            $designation = $locations->designation,
            $depart = $locations->depart,
            $destination = $locations->destination,
            $quantite = $locations->quantite,
            $jour = $locations->jour,
            $forfait = $locations->forfait,
            $ht = $locations->ht,
            $tva = $locations->tva,
            $ttc = $locations->ttc,
            $totalNetLettre = $locations->totalNetLettre,
            $nbrePlace = $locations->nbrePlace,
            $heureDepart = $locations->heureDepart,
            $heureArrive = $locations->heureArrive
        ));
        return $pdf->stream();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //

        $locations = location::find($id);

        return view('pages.update', compact('locations'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
        $location = location::find($id);

       return $request->interlocuteur;

        $location->interlocuteur = $request->interlocuteur;
        $location->mobile = $request->mobile;
        $location->email = $request->email;
        $location->client = $request->client;
        $location->periodeDebut = $request->periodeDebut;
        $location->periodeFin = $request->periodeFin;
        $location->designation = $request->designation;
        $location->destination = $request->destination;
        $location->depart = $request->depart;
        $location->quantite = $request->quantite;
        $location->jour = $request->jour;
        $location->forfait = $request->forfait;
        $location->ht = $request->ht;
        $location->tva = $request->tva;
        $location->ttc = $request->ttc;
        $location->totalNetLettre = $request->totalNetLettre;
        $location->nbrePlace = $request->nbrePlace;
        $location->heureDepart = $request->heureDepart;
        $location->heureArrive = $request->heureArrive;
        $location->save();
        return 'ok';
        // return redirect('/')->with('success', 'Votre facture est modifiée');
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
