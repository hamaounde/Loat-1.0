@extends('layouts.app')
@section('content')

    <form class="" method="PATCH" action="location/{{$locations->id}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <h3 class="col-12" style="background-color:green">Entreprise</h3>
            <div class="col-4 bg-secondary">
                <div class="form-group">
                    <label for="datecourrent">Interlocuteur  : </label>
                        <input type="text" name="interlocuteur" class="form-control" value="Mohamadou Awalou Saliou" />
                </div>
            </div>

            <div class="col-4 bg-secondary">
                <div class="form-group">
                    <label for="datecourrent">Mobile   : </label>
                    <input type="text" name="mobile" class="form-control" value="699836662" />
                </div>
            </div>

            <div class="col-4 bg-secondary">
                <div class="form-group">
                    <label for="datecourrent">Email   : </label>
                        <input type="email" name="email" class="form-control" value="mohamadou78@yahoo.fr "/>
                </div>
            </div>
        </div>

        <div class="row">
            <h1 class="col-12 justify-content-center" style="background-color:green; margin-top:20px; ">Client</h1>
            <div class="form-group col-12 bg-secondary" style="padding-bottom:20px">
                <label for="exampleInputEmail1">Client</label>
                <input type="text" name="client" class="form-control" id="exampleInputEmail1" value="{{$locations->client}}">
            </div>
        </div>

        <div class="row">
            <h1 class="col-12 justify-content-center" style="background-color:green; margin-top:20px; ">Location</h1>
            <div class="col-4 form-group">
                <label for="exampleInputEmail1">Itinéraire (départ)</label>
                <input type="text" name="depart" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$locations->depart}}">
            </div>
            <div class="col-4 form-group">
                <label for="exampleInputEmail1">Itinéraire (destination)</label>
                <input type="text" name="destination" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$locations->destination}}">
            </div>
            <div class="col-4 form-group">
                <label for="exampleInputEmail1">heure départ</label>
                <input type="time" name="heureDepart" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$locations->heureDepart}}">
            </div>
            <div class="col-4 form-group">
                <label for="exampleInputEmail1">heure départ</label>
                <input type="time" name="heureArrive" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$locations->heureArrive}}">
            </div>
            <div class="col-4 form-group">
                <label for="exampleInputPassword1">Nombre de vehicule</label>
                <input type="number" name="quantite" class="form-control" min="1" id="nbreVehicule" oninput="myFunction()" value="{{$locations->quantite}}">
            </div>
            <div class="col-4 form-group">
                <label for="exampleInputPassword1">Nombre du jour</label>
                <input type="number" name="jour" class="form-control" min="1" id="jour" oninput="myFunction()" value="{{$locations->jour}}">
            </div>
            <div class="col-4 form-group">
                <label for="periode debut">Pédiode début</label>
                <input type="date" name="periodeDebut" class="form-control" id="" value="{{$locations->periodeDebut}}" >
            </div>
            <div class="col-4 form-group">
                <label for="periode fin">Pédiode fin</label>
                <input type="date" name="periodeFin" class="form-control" id="" value="{{$locations->periodeFin}}">
            </div>
            <div class="col-4 form-group">
                <label for="exampleInputPassword1">Forfait</label>
                <input type="number" name="forfait" class="form-control" id="forfait" min="1" oninput="myFunction()" value="{{$locations->forfait}}">
            </div>
        </div>
        <div class="row">
            <h1 class="col-12 justify-content-center" style="background-color:green; margin-top:20px; ">Montant</h1>
            <div class="col-3 form-group">
                <label for="ht">Selectioner:</label>
                <select class="form-control" name="taxe" id="taxe" oninput="myFunction()">
                    <option  value="1" selected>AVEC TVA</option>
                    <option value="0">PAS DE TVA</option>
                </select>
            </div>
            <div class="col-3 form-group">
                <label for="ht">Montant HT: </label>
                <input type="number" name="ht" class="form-control" id="montantHT" value=""/>
            </div>
            <div class="col-3 form-group">
                <label for="ht">TVA 19.25% : </label>
                <input type="text" name="tva" class="form-control" id="tva" value=""/>
            </div>
            <div class="col-3 form-group">
                <label for="ht">Montant net TTC: </label>
                <input type="text" name="ttc" class="form-control" id="montantTTC" value=""/>
            </div>
            <div class="col-12 form-group">
                <label for="totalNetLettre">Total net en lettres: </label>
                <input name="totalNetLettre" class="form-control" id="totalNetLettre" value="{{$locations->totalNetLettre}}">
            </div>
        </div>

        <div class="row">
            <h3  class="col-12 justify-content-center" style="background-color:green; margin-top:20px; ">Caracteristique du vehicule</h3>
            <div class="col-12 form-group">
                    <label for="datecourrent">Nombre de place : </label>
                    <input type="number" name="nbrePlace" class="form-control"  value="{{$locations->nbrePlace}}" />
            </div>
        </div>
        <div class="col-12 form-group">
            <div class="clearfix" style="">
                <button type="submit" class="btn btn-sm btn-success align-content-end">Enregistrer</button>
            </div>
        </div>

    </form>
@endsection

<script>
    function myFunction() {
        var x=0, n=1, y=0, z=0, k=0, j=1;
        n = document.getElementById('nbreVehicule').value; //nombre de vehicule
        j = document.getElementById('jour').value; //nombre de jours
        x = document.getElementById("forfait").value;   // forfait
        t = document.getElementById("taxe").value;   // forfait
        k= (x*n*j); // application du montant HT
        y = (k * 19.25)/100;  // application du TVA
        z = (k+y); // application du montant TTC
        document.getElementById("montantHT").value = k;
        document.getElementById("tva").value = y*t;
        document.getElementById("montantTTC").value = z*t;
    }
</script>
