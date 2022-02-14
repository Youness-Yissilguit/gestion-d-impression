
<!DOCTYPE html>
<html>
 <head>
  <title>Laravel - How to Generate Dynamic PDF from HTML using DomPDF</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }
  </style>
 </head>
 <body>
  <br />
  <div class="container">
   <h3 align="center">Detail De La Facture</h3><br />

   <div class="row">
    <div class="col-md-7" align="right">
     <h4>Customer Data</h4>
    </div>
    <div class="col-md-5" align="right">
     <a href="{{ url('pdf') }}" class="btn btn-danger">Convert into PDF</a>
    </div>
   </div>
   <br />
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <thead>
      <tr>
       <th>lieu instalation</th>
       <th>N serie</th>
       <th>Date install</th>
       <th>Anc. Cptr N</th>
       <th>ACptr. Actuel N</th>
       <th>Nr copie N</th>
       <th>Forfait</th>
      </tr>
     </thead>
     <tbody>
     @foreach($data as $contrat)
      <tr>
       <td>{{ $contrat->lieu_nome }}</td>
       <td>{{ $contrat->num_serie }}</td>
       <td>{{ $contrat->date_instal }}</td>
       <td>{{ $contrat->cmpt_inc }}</td>
       <td>{{ $contrat->nbt_impr }}</td>
       <td>{{ $contrat->nbt_impr - $contrat->cmpt_inc }}</td>
       <td>{{ $contrat->cout_nb *  ($contrat->nbt_impr - $contrat->cmpt_inc)}} DH</td>
      </tr>
     @endforeach
     </tbody>
    </table>
   </div>
  </div>
 </body>
</html>

