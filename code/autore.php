<!DOCTYPE HTML>
<html>
<head>
  <title>Autori</title>
  <link rel="stylesheet" href="./css/cssPage.css">
  <link rel="stylesheet" href="./css/cssHeader.css">
  <link rel="stylesheet" href="./css/cssFooter.css">
  <link rel="stylesheet" href="./css/cssLoading.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap">
  <script type="text/javascript" src="./js/jquery-2.0.0.js"></script>
  <script type="text/javascript" src="./js/jsLoading.js"></script>
  <script type="text/javascript" src="./js/jsFiltersMove.js"></script>
  <script type="text/javascript" src="./js/jsAutore.js"></script>
  <script type="text/javascript" src="./js/jsFooter.js"></script>
</head>

<body>
  <?php
  $page='Autori';
  include 'header.php';
  include 'nav.html';
  ?>

  <div class="caricamento">
    <span>...</span>
  </div>

  <button id="bottoneFiltri" class="filterButton" onclick="moveFilters()">
    <img src="../img/filtroStatica.png">
  </button>


  <div id="filtri" class="filters">
    <form name="myform" class="form" method="POST">
      <ul class="filterContainer">
        <li class="filterHeader">
          <span class="filterTitle">Gestisci Autori</span>
        </li>
        <li class="filterItem">
          <button id="CRUD" name="CRUD" class="button" type="submit" value="CRUD">
            <span class="buttonText">Gestisci</span>
            <span class="buttonIcon">
              <img src="../img/crud.png">
            </span>
          </button>
          <button id="backButton" name="back" class="button" type="submit" value="Back" onclick="hideCreateButton()">
            <span class="buttonText">Chiudi</span>
            <span class="buttonIcon">
              <img src="../img/indietro.png">
            </span>
          </button>
        </li>
        <li class="filterHeader2">
          <span class="filterTitle">Filtri</span>
        </li>
        <li class="filterItem">
          <button type="submit" id="cerca" name="cerca" class="button" value="cerca">
            <span class="buttonText">Cerca</span>
            <span class="buttonIcon">
              <img src="../img/cerca.png">
            </span>
          </button>
          <button type="submit" class="button">
            <span class="buttonText">Reset</span>
            <span class="buttonIcon">
              <img src="../img/reset.png">
            </span>
          </button>
        </li>
        <div class="filterScroll">
          <li class="filterItem">
            <input id="codice" class="input" name="codice" type="text" oninput="controllaCodice()"/>
            <label class="placeHolder">Codice</label>
          </li>
          <li class="filterItem">
            <input id="nome" class="input" name="nome" type="text"/>
            <label class="placeHolder">Nome</label>
          </li>
          <li class="filterItem">
            <input id="cognome" class="input" name="cognome" type="text"/>
            <label class="placeHolder">Cognome</label>
          </li>
          <li class="filterItem">
            <input id="nazione" class="input" name="nazione" type="text"/>
            <label class="placeHolder">Nazione</label>
          </li>
          <li class="filterItem">
            <input id="dataNascita" class="input" name="dataNascita" type="text"/>
            <label class="placeHolder">Data Nascita</label>
          </li>
          <li class="filterItem">
            <input id="dataMorte" class="input" name="dataMorte" type="text"/>
            <label class="placeHolder">Data Morte</label>
          </li>
          <li class="filterItemLast">
            <input id="numeroOpere" class="input" name="numeroOpere" type="text"/>
            <label class="placeHolder">Numero Opere</label>
          </li>
          <li>
            <form name="myform2" class="form" method="post">
              <ul class="filterContainer2">
                <li class="filterItem">
                  <input id="opera" class="input" name="nomeopera" type="text">
                  <label class="placeHolder">Titolo dell'opera</label>
                </li>
                <li class="filterItem">
                  <button type="submit" class="button">
                    <span class="buttonText">Cerca per opera</span>
                    <span class="buttonIcon">
                      <img src="../img/operaStatica.png">
                    </span>
                  </button>
                </li>
              </ul>
            </form>
          </li>
        </div>
      </ul>
    </form>
  </div>

  <div id="options" style="display:none;">
    <button id="createButton" class="button" onclick="showCreateForm()">Creare</button>
  </div>

 <!--inizializzazione dei campi per gli inserimenti -->
  <div id="result" class="tableBody">
    <?php
    $codice = "";
    $nome = "";
    $cognome  = "";
    $nazione = "";
    $dataNascita  = "";
    $dataMorte = "";
    $tipo = "";
    $numeroOpere  = "";
    $nomeopera="";
    $mostra = false;

    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'codice';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';


     //metodo Post per ottenimento dati
    if(count($_POST) > 0) {
      $codice = $_POST["codice"];
      $nome = $_POST["nome"];
      $cognome  = $_POST["cognome"];
      $nazione = $_POST["nazione"];
      $dataNascita  = $_POST["dataNascita"];
      $dataMorte = $_POST["dataMorte"];
      $tipo = $_POST["tipo"];
      $numeroOpere  = $_POST["numeroOpere"];
      $nomeopera  = $_POST["nomeopera"];
    } else if(count($_GET) > 0) {
      $codice = $_GET["codice"];
      $nome = $_GET["nome"];
      $cognome  = $_GET["cognome"];
      $nazione = $_GET["nazione"];
      $dataNascita  = $_GET["dataNascita"];
      $dataMorte = $_GET["dataMorte"];
      $tipo = $_GET["tipo"];
      $numeroOpere  = $_GET["numeroOpere"];
      $nomeopera  = $_GET["nomeopera"];
    }

    //imposto la variabile mostra a true se viene premuto CRUD

    if (isset($_POST['CRUD']) && $_POST['CRUD'] === 'CRUD') {
       $mostra = true;
    }

    if (isset($_POST['cerca']) && $_POST['cerca'] === 'cerca') {
       $mostra = true;
     }

    include 'autoreManager.php';
    $error = false;

    //query al database
    require_once 'connDb.php';
    $query = getAutoreQry($codice, $nome, $cognome, $nazione, $dataNascita, $dataMorte, $tipo, $numeroOpere, $nomeopera, $sort_by, $sort_order);

    try {
      $result = $conn->query($query);
    } catch(PDOException $e) {
      echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
      $error = true;
    }
    //se non è stato premuto il tasto di crud (non mostro le colonne per modifica e eliminazione)
    if(!$mostra && !$error) {

      if($nomeopera==""){
        ?>

        <table>
          <thead>
            <tr>
              <th>CODICE
                <button class="iconArrow" onclick="window.location.href='?sort_by=codice&sort_order=<?php echo $sort_by === 'codice' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>NOME
                <button class="iconArrow" onclick="window.location.href='?sort_by=nome&sort_order=<?php echo $sort_by === 'nome' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>COGNOME
                <button class="iconArrow" onclick="window.location.href='?sort_by=cognome&sort_order=<?php echo $sort_by === 'cognome' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>NAZIONE
                <button class="iconArrow" onclick="window.location.href='?sort_by=nazione&sort_order=<?php echo $sort_by === 'nazione' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>DATA NASCITA
                <button class="iconArrow" onclick="window.location.href='?sort_by=dataNascita&sort_order=<?php echo $sort_by === 'dataNascita' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>DATA MORTE
                <button class="iconArrow" onclick="window.location.href='?sort_by=dataMorte&sort_order=<?php echo $sort_by === 'dataMorte' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>TIPO
                <button class="iconArrow" onclick="window.location.href='?sort_by=tipo&sort_order=<?php echo $sort_by === 'tipo' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>NUMERO OPERE
                <button class="iconArrow" onclick="window.location.href='?sort_by=numeroOpere&sort_order=<?php echo $sort_by === 'numeroOpere' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
            </tr>
          </thead>
          <tbody>

            <?php
            foreach($result as $riga) {
              $codice = $riga["codice"];
              $nome = $riga["nome"];
              $cognome  = $riga["cognome"];
              $nazione = $riga["nazione"];
              $dataNascita  = $riga["dataNascita"];
              $dataMorte = $riga["dataMorte"];
              $tipo = $riga["tipo"];
              $numeroOpere  = $riga["numeroOpere"];

              ?>
              <tr>
                <td><?php echo $codice; ?></td>
                <td><?php echo $nome; ?></td>
                <td><?php echo $cognome; ?></td>
                <td><?php echo $nazione; ?></td>
                <td><?php echo $dataNascita; ?></td>
                <td><?php echo $dataMorte; ?></td>
                <td><?php echo $tipo; ?></td>
                <td>
                  <a href="opera.php?autore=<?php echo urlencode($codice); ?>">
                    <?php echo $numeroOpere; ?>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php }

      //se è stato inserito qualcosa nel filtro di ricerca del nome opera
      elseif ($nomeopera!="") {
        ?>
        <table>
          <thead>
            <tr>
              <th>CODICE
                <button class="iconArrow" onclick="window.location.href='?sort_by=codice&sort_order=<?php echo $sort_by === 'codicee' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>NOME
                <button class="iconArrow" onclick="window.location.href='?sort_by=nome&sort_order=<?php echo $sort_by === 'nome' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>COGNOME
                <button class="iconArrow" onclick="window.location.href='?sort_by=cognome&sort_order=<?php echo $sort_by === 'cognome' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>NAZIONE
                <button class="iconArrow" onclick="window.location.href='?sort_by=nazione&sort_order=<?php echo $sort_by === 'nazione' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>DATA NASCITA
                <button class="iconArrow" onclick="window.location.href='?sort_by=dataNascita&sort_order=<?php echo $sort_by === 'dataNascita' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>DATA MORTE
                <button class="iconArrow" onclick="window.location.href='?sort_by=dataMorte&sort_order=<?php echo $sort_by === 'dataMorte' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>TIPO
                <button class="iconArrow" onclick="window.location.href='?sort_by=tipo&sort_order=<?php echo $sort_by === 'tipo' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>NUMERO OPERE
                <button class="iconArrow" onclick="window.location.href='?sort_by=numeroOpere&sort_order=<?php echo $sort_by === 'numeroOpere' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
              <th>TITOLO OPERA
                <button class="iconArrow" onclick="window.location.href='?sort_by=numeroOpere&sort_order=<?php echo $sort_by === 'numeroOpere' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                  <img src="./img/freccia.png">
                </button>
              </th>
            </tr>
          </thead>
          <tbody>

            <?php
            foreach($result as $riga) {
              $codice = $riga["codice"];
              $nome = $riga["nome"];
              $cognome  = $riga["cognome"];
              $nazione = $riga["nazione"];
              $dataNascita  = $riga["dataNascita"];
              $dataMorte = $riga["dataMorte"];
              $tipo = $riga["tipo"];
              $numeroOpere  = $riga["numeroOpere"];
              $nomeopera  = $riga["nomeopera"];
              ?>
              <tr>
                <td><?php echo $codice; ?></td>
                <td><?php echo $nome; ?></td>
                <td><?php echo $cognome; ?></td>
                <td><?php echo $nazione; ?></td>
                <td><?php echo $dataNascita; ?></td>
                <td><?php echo $dataMorte; ?></td>
                <td><?php echo $tipo; ?></td>
                <td><?php echo $numeroOpere; ?></td>
                <td><a href="opera.php?titolo=<?php echo urlencode($nomeopera); ?>"><?php echo $nomeopera; ?></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php
      }

      // se è stato premuto il bottone di CRUD
    } else if($mostra && !$error) { ?>
      <div>
        <button id="createButton" class="buttonCrea" onclick="showCreateForm()">
          <span class="buttonText">Inserisci Autore</span>
          <span class="buttonIcon">
            <img src="../img/inserisci.png">
          </span>
        </button>
      </div>

      <div id="createForm" class="popup">
        <div class="overlay">
          <div class="content">
            <div class="closePop" onclick="showCreateForm()">
              &times;
            </div>
            <div class="titlePop">
              <span> Inserisci nuovo autore</span>
            </div>
            <form id="createAuthorForm" method="post" action="insertAuthor.php" onsubmit="return validateForm()">
              <ul class="popContainer">
                <div class="popScroll">
                  <li class="popItem">
                    <input id="codicecreate" class="inputPop" name="codicecreate" type="text">
                    <label class="placeHolderPop">Codice</label>
                  </li>
                  <li class="popItem">
                    <input id="nomecreate" class="inputPop" name="nomecreate" type="text">
                    <label class="placeHolderPop">Nome</label>
                  </li>
                  <li class="popItem">
                    <input id="cognomecreate" class="inputPop" name="cognomecreate" type="text">
                    <label class="placeHolderPop">Cognome</label>
                  </li>
                  <li  class="popItem">
                    <input id="nazionecreate" class="inputPop" name="nazionecreate" type="text">
                    <label class="placeHolderPop">Nazione</label>
                  </li>
                  <li class="popItem">
                    <input id="dataNascitacreate" class="inputPop" name="dataNascitacreate" type="text">
                    <label class="placeHolderPop">Data Nascita</label>
                  </li>
                  <li class="popItem">
                    <input id="dataMortecreate" class="inputPop" name="dataMortecreate" type="text">
                    <label class="placeHolderPop">Data Morte</label>
                  </li>
                </div>
              </ul>
              <button class="button" type="submit" name="insert" >
                <span class="buttonText">Inserisci</span>
                <span class="buttonIcon">
                  <img src="../img/inserisci.png">
                </span>
              </button>
            </form>
          </div>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Modifica</th>
            <th>Elimina</th>
            <th>CODICE
              <button class="iconArrow" onclick="window.location.href='?sort_by=codice&sort_order=<?php echo $sort_by === 'codicee' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>NOME
              <button class="iconArrow" onclick="window.location.href='?sort_by=nome&sort_order=<?php echo $sort_by === 'nome' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>COGNOME
              <button class="iconArrow" onclick="window.location.href='?sort_by=cognome&sort_order=<?php echo $sort_by === 'cognome' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>NAZIONE
              <button class="iconArrow" onclick="window.location.href='?sort_by=nazione&sort_order=<?php echo $sort_by === 'nazione' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>DATA NASCITA
              <button class="iconArrow" onclick="window.location.href='?sort_by=dataNascita&sort_order=<?php echo $sort_by === 'dataNascita' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>DATA MORTE
              <button class="iconArrow" onclick="window.location.href='?sort_by=dataMorte&sort_order=<?php echo $sort_by === 'dataMorte' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>TIPO
              <button class="iconArrow" onclick="window.location.href='?sort_by=tipo&sort_order=<?php echo $sort_by === 'tipo' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
            <th>NUMERO OPERE
              <button class="iconArrow" onclick="window.location.href='?sort_by=numeroOpere&sort_order=<?php echo $sort_by === 'numeroOpere' && $sort_order === 'asc' ? 'desc' : 'asc'; ?>&codice=<?php echo $codice; ?>&nome=<?php echo $nome; ?>&cognome=<?php echo $cognome; ?>&nazione=<?php echo $nazione; ?>&dataNascita=<?php echo $dataNascita; ?>&dataMorte=<?php echo $dataMorte; ?>&tipo=<?php echo $tipo; ?>&numeroOpere=<?php echo $numeroOpere; ?>&nomeopera=<?php echo $nomeopera; ?>'">
                <img src="./img/freccia.png">
              </button>
            </th>
          </tr>
        </thead>
        <tbody>

          <?php
          foreach($result as $riga) {
            $codice = $riga["codice"];
            $nome = $riga["nome"];
            $cognome  = $riga["cognome"];
            $nazione = $riga["nazione"];
            $dataNascita  = $riga["dataNascita"];
            $dataMorte = $riga["dataMorte"];
            $tipo = $riga["tipo"];
            $numeroOpere  = $riga["numeroOpere"];

            ?>
            <tr>
              <td>
                <button class="modifica-button" data-id="<?php echo $codice; ?>" onclick="showEditForm(<?php echo $codice; ?>)">
                  <img src="../img/modifica.png">
                </button>
              </td>
              <td>
                <button class="cancella-button" data-id="<?php echo $codice; ?>" onclick="cancellaAutore(<?php echo $codice; ?>)">
                  <img src="../img/cancella.png">
                </button>
              </td>

              <td><?php echo $codice; ?></td>
              <td><?php echo $nome; ?></td>
              <td><?php echo $cognome; ?></td>
              <td><?php echo $nazione; ?></td>
              <td><?php echo $dataNascita; ?></td>
              <td><?php echo $dataMorte; ?></td>
              <td><?php echo $tipo; ?></td>
              <td><a href="opera.php?autore=<?php echo urlencode($codice); ?>"><?php echo $numeroOpere; ?></a></td>
            </tr>
            <tr id="editFormRow<?php echo $codice; ?>" style="display: none;">
              <form id="editForm<?php echo $codice; ?>" method="post" action="editAuthor.php" onsubmit="return validateForm()">
                <td></td>
                <td></td>
                <td>
                  <input type="hidden" name="codice" value="<?php echo $codice; ?>">
                </td>
                <td>
                  <input id="nomecreate" class="inputModify" name="nomecreate" type="text" placeholder="Nome">
                </td>
                <td>
                  <input id="cognomecreate" class="inputModify" name="cognomecreate" type="text" placeholder="Cognome">
                </td>
                <td>
                  <input id="nazionecreate" class="inputModify" name="nazionecreate" type="text" placeholder="Nazione">
                </td>
                <td>
                  <input id="dataNascitacreate" class="inputModify" name="dataNascitacreate" type="text" placeholder="Data Nascita">
                </td>
                <td>
                  <input id="dataMortecreate" class="inputModify" name="dataMortecreate" type="text" placeholder="Data Morte">
                </td>
                <td>
                  <button type="submit" class="buttonModify" name="edit" value="Modifica">
                    <span class="buttonModifyText">Conferma</span>
                  </button>
                </td>
                <td></td>
              </form>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  </div>
  <?php
  include 'footer.html';
  ?>
</body>
</html>
