<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrats;
use Illuminate\Support\Facades\App;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class PdfController extends Controller
{
    //relver de fournisseur
    public function relverIndex($id){
        $data = DB::table('contrat')
                    ->join('imprimante', 'imprimante.id_imprt', '=', 'contrat.id_imprimante')
                    ->join('lieu', 'imprimante.lieu_instal', '=', 'lieu.lieu_id')
                    ->join('fournisseur', 'contrat.id_fournisseur', '=', 'fournisseur.f_id')
                    ->join('compteur', 'compteur.id_imp', '=', 'imprimante.id_imprt')
                    ->where('fournisseur.f_id', $id)
                    ->select('compteur.nbt_impr', 'lieu.nome as lieu_nome','fournisseur.nome as f_nome', 'contrat.cout_nb',
                             'imprimante.num_serie', 'imprimante.cmpt_inc','imprimante.date_instal', 'imprimante.id_imprt',
                             'imprimante.id_imprt', 'fournisseur.fax', 'fournisseur.nome as f_nom'
                            )
                    ->get();
        $anc_compteur = array();
        foreach ($data as $val) {
            $temps = DB::table('compteur_trace')->orderBy('date_relver', 'desc')->where('id_imp',$val->id_imprt)->skip(0)->take(1)->get();
            foreach ($temps as $temp){
                array_push($anc_compteur, $temp);
            }
        }
        return view('admin.relver', [
            'data' => $data,
            'last_compt' => $anc_compteur
        ]);
    }
    public function relverIndexSearsh($id){
        $data = DB::table('contrat')
                    ->join('imprimante', 'imprimante.id_imprt', '=', 'contrat.id_imprimante')
                    ->join('lieu', 'imprimante.lieu_instal', '=', 'lieu.lieu_id')
                    ->join('fournisseur', 'contrat.id_fournisseur', '=', 'fournisseur.f_id')
                    ->join('compteur', 'compteur.id_imp', '=', 'imprimante.id_imprt')
                    ->where('fournisseur.f_id', $id)
                    ->where('imprimante.num_serie', request('num_serie'))
                    ->select('compteur.nbt_impr', 'lieu.nome as lieu_nome','fournisseur.nome as f_nome', 'contrat.cout_nb',
                             'imprimante.num_serie', 'imprimante.cmpt_inc','imprimante.date_instal', 'imprimante.id_imprt',
                             'imprimante.id_imprt', 'fournisseur.fax'
                            )
                    ->get();
        $anc_compteur = array();
        foreach ($data as $val) {
            $temps = DB::table('compteur_trace')->orderBy('date_relver', 'desc')->where('id_imp',$val->id_imprt)->skip(0)->take(1)->get();
            foreach ($temps as $temp){
                array_push($anc_compteur, $temp);
            }
        }
        return view('admin.relver', [
            'data' => $data,
            'last_compt' => $anc_compteur
        ]);
    }
    //trace de compteur
    public function compteurTrace($id){
        $compteurs = DB::table('compteur_trace')->where('id_imp', $id)->orderBy('compteur', 'desc')
                        ->join('imprimante', 'compteur_trace.id_imp', '=', 'imprimante.id_imprt')
                        ->select('compteur_trace.*', 'imprimante.num_serie')->get();
        return view('admin.compteurTrace', [
            'compteurs' => $compteurs
        ]);
    }
    //searsh compteur trace
    public function compteurTraceSearsh($id){
        $compteurs = DB::table('compteur_trace')->where('id_imp', $id)->orderBy('compteur', 'desc')
                                                ->whereRaw('MONTH(compteur_trace.date_relver) = ' . Carbon::parse(request('date_trace'))->month)
                                                ->whereRaw('YEAR(compteur_trace.date_relver) = ' . Carbon::parse(request('date_trace'))->year)
                                                ->join('imprimante', 'compteur_trace.id_imp', '=', 'imprimante.id_imprt')
                                                ->select('compteur_trace.*', 'imprimante.num_serie')
                                                ->get();
        return view('admin.compteurTrace', [
        'compteurs' => $compteurs
        ]);
    }
    function index(){
     $data = $this->get_data(3);
     return view('helpers.dynamic_pdf')->with('data', $data);
    }

    function get_data($id){
    $data = DB::table('contrat')
                ->join('imprimante', 'imprimante.id_imprt', '=', 'contrat.id_imprimante')
                ->join('lieu', 'imprimante.lieu_instal', '=', 'lieu.lieu_id')
                ->join('fournisseur', 'contrat.id_fournisseur', '=', 'fournisseur.f_id')
                ->join('compteur', 'compteur.id_imp', '=', 'imprimante.id_imprt')
                ->where('fournisseur.f_id', $id)
                ->select('compteur.nbt_impr', 'lieu.nome as lieu_nome','fournisseur.nome as f_nome', 'contrat.cout_nb',
                        'imprimante.num_serie', 'imprimante.cmpt_inc','imprimante.date_instal', 'imprimante.id_imprt',
                        'imprimante.id_imprt', 'fournisseur.fax', 'fournisseur.adresse', 'fournisseur.nome as f_nome'
                        )
                ->get();
        return $data;
    }

    function pdf($id){
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html($id));
        return $pdf->stream();
    }

    function convert_customer_data_to_html($id){
     $data = $this->get_data($id);
     $output = '
     <h4>Fournisseur: '. $data[0]->f_nome .'</h4>
     <h4>Numero tel: 0'. $data[0]->fax .'</h4>
     <h4>Adress: '. $data[0]->adresse .'</h4>
     <h3 align="center">Detail de la facture</h3>
     <table width="100%" style="border-collapse: collapse; border: 1px solid #555;" class="table">
      <tr style="border-collapse: collapse; border: 1px solid #555;">
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">lieu instalation</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" style="border-collapse: collapse; border: 1px solid #555;" scope="col">N serie</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">Date relver</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">Anc. Cptr N</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">Cptr. Actuel N</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">cout</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">Nr copie N</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">Forfait</th>
      <th style="border-collapse: collapse; border: 1px solid #555;" scope="col">montant</th>
      </tr>
     ';
    $total = 0;
    $nbr_c = 0;
    foreach($data as $contrat)
    {
      $last_compt = DB::table('compteur_trace')->orderBy('date_relver', 'desc')->where('id_imp',$contrat->id_imprt)->skip(0)->take(1)->get();
      $output .= '
      <tr>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;padding:15px">' .  $contrat->lieu_nome . '</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' .  $contrat->num_serie . '</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' .  date('d-m-Y', strtotime($last_compt[0]->date_relver)) . '</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' .  $last_compt[0]->compteur . '</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' .  $contrat->nbt_impr . '</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' .  $contrat->cout_nb . ' dh</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' .  ($contrat->nbt_impr - $last_compt[0]->compteur) . '</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">175,00</td>
            <td style="border-collapse: collapse; border: 1px solid #555;font-size: 13px; text-align: center;">' . round($contrat->cout_nb * ($contrat->nbt_impr - $contrat->cout_nb) + 175, 2) . ' DH</td>
      </tr>
    ';
        $total += round($contrat->cout_nb * ($contrat->nbt_impr - $contrat->cout_nb) + 175, 2);
        $nbr_c += ($contrat->nbt_impr - $last_compt[0]->compteur);
    }
     $output .= '</table>
                <h3>Nbr total de coupie: '. $nbr_c .'</h3>
                <h2 align="">
                    Montant total: <b>'. $total .' DH</b>
                </h2>';
     return $output;
    }
    public function exportCsv($id){
        $fileName = 'facture.csv';
        $tasks = $this->get_data($id);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('lieu instalation', 'N serie', 'Date install', 'Anc. Cptr N', 'ptr. Actuel N',
                        'cout','Nr copie N', 'Forfait', 'montant');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $last_compt = DB::table('compteur_trace')->select('compteur')->orderBy('date_relver', 'desc')
                                ->where('id_imp',$task->id_imprt)->skip(0)->take(1)->get();
                $row['lieu instalation']  = $task->lieu_nome;
                $row['N serie'] = $task->num_serie;
                $row['Date install'] = $task->date_instal;
                $row['Anc. Cptr N']  = $last_compt[0]->compteur;
                $row['ptr. Actuel N']  = $task->nbt_impr;
                $row['cout']  = $task->cout_nb;
                $row['Nr copie N']  =($task->nbt_impr - $last_compt[0]->compteur);
                $row['Forfait']  = 175.00;
                $row['montant']  =  round($task->cout_nb * ($task->nbt_impr - $task->cout_nb) + 175, 2);

                fputcsv($file, array($row['lieu instalation'], $row['N serie'], $row['Date install'], $row['Anc. Cptr N']
                                    ,$row['ptr. Actuel N'], $row['cout'], $row['Nr copie N'], $row['Forfait'], $row['montant']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
