
@extends('../layout/structure')

@section('title', 'Tableau de bord')



@section('content')
    @include('../layout/navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="/public/dashboard" class="active">Tableau de bord /</a></li>
            </ul>
        </div>
    </div>
    <section class="header_wrapper">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md">
                    <div class="imp_box mb-5 mt-4">
                        <h4>
                            <?php echo ($sum_imp<10) ?  '0'. $sum_imp : $sum_imp;?> <br>
                            Imprimantes
                        </h4>
                    </div>
                    <div class="imp_box mb-5 mt-4">
                        <h4>
                            <?php echo ($sum_cnt<10) ?  '0'. $sum_cnt : $sum_cnt;?> <br>
                            Contrats
                        </h4>
                    </div>
                </div>
                <div class="col-md">
                    <h4 class="type_title mb-3">Administration</h4>
                    <div class="row">
                        <div class="col-md">
                            <div class="adm_box">
                                <h3>
                                    <?php echo ($sum_u<10) ?  '0'. $sum_u : $sum_u;?> <br>
                                    utilisateurs
                                </h3>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="adm_box">
                                <h3>
                                    <?php echo ($fourni_sum<10) ?  '0'. $fourni_sum : $fourni_sum;?> <br>
                                    fournisseurs
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="type_title mt-5">Ticket</h4>
            <div class="row mt-3">
                <div class="col-md">
                    <div class="tick_box y">
                        <h4>
                            <?php echo ($sum<10) ?  '0'. $sum : $sum;?> <br>
                            Tickets
                        </h4>
                    </div>
                </div>
                <div class="col-md">
                    <div class="tick_box r">
                        <h4>
                            <?php echo ($sum_nr<10) ?  '0'. $sum_nr : $sum_nr;?> <br>
                            Tickets non résolus
                        </h4>
                    </div>
                </div>
                <div class="col-md">
                    <div class="tick_box g">
                        <h4>
                            <?php echo ($sum_r<10) ?  '0'. $sum_r : $sum_r;?> <br>
                            Ticket résolus
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
