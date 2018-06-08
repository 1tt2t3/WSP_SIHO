<?php
require 'resources/includes/db_conn.php'; // Require frågar om filen db_conn.php finns. För om den inte fanns så skulle koden gå hela vägen till slutet där det skulle echo:a ut ett ERROR meddelande

if ($pdo) {

    //Variabeln $sql används för att hitta de olika inläggen som kommer att skrivas på sidan.
    //P.ID. Är ID:t på inlägget.
    //P.Headline. Är namnet på inlägget.
    //CONCAT(U.Firstname, " ", U.Lastname) AS Name. Frågar efter namnet och efternamnet på användaren och sätter ihop dem som bara ett namn.
    //P.Creation_time. Är när den gjordes.
    //P.Text. Är texten som skrevs i inlägget.
    //FROM Posts AS P. Beskriver ifrån vilken databas som informationen kommer att tas ifrån och att det kommer att skrivas som P.
    //JOIN Users AS U. De sätts ihop som U.
    //ORDER BY P.Creation_time DESC. Är ordningen som inläggen kommer att sorteras efter och vilken tid som den skrevs och det kommer att börja med det senaste/tidigaste som blivit skrivet.

    $sql = 'SELECT P.ID, P.Slug, P.Headline, CONCAT(U.Firstname, " ", U.Lastname) AS Name, P.Creation_time,  P.Text  FROM Posts AS P JOIN Users AS U  ON U.ID = P.User_ID ORDER BY P.Creation_time DESC';

    // Om någon skriver någonting i sökrutan så kommer det att bli värdet på $data som senare kommer att användas
     if (isset($_POST['search'])) {
        //Vilket händer här
        $data = $_POST['what'];


        /**********************************************************/
        /*********************** C-UPPGIFT 1 **********************/
        /*** Variabeln $data kan innehålla, som den är utformad, **/
        /********* information som kan skada vår databas. *********/
        /*** För betyget C så kräver jag att ni säkerställer att **/
        /***** $data inte innehåller någon form av skadlig kod ****/
        /**********************************************************/

        /**********************************************************/
        /*********************** C-UPPGIFT 2 **********************/
        /* I filen all-posts.php så skrivs det ut en kortare text */
        /* följt av en länk till berört inlägg. Vore det inte mer */
        /* passande att det istället skrivs ut ord från inlägget? */
        /* För betyget C så kräver jag att ni tar fram en lösning */
        /**** där 10 ord från inlägget skrivs ut före läs mer. ****/
        /************ Tänk implode och/eller explode! *************/
        /**********************************************************/

        /**********************************************************/
        /************************ A-UPPGIFT ***********************/
        /** Som det är just nu så tar vi bara in en variabel som **/
        /******* vi använder när vi söker igenom databasen. *******/
        /* Tittar man på sidor som exempelvis google och facebook */
        /**** så kan din sökning oftast innehålla flera sökord ****/
        /* För betyget A så kräver jag att ni tar fram en lösning */
        /** som gör det möjligt för användaren att kunna söka på **/
        /** flera separerade ord. Att man exempelvis kan söka på **/
        /***** texter som innehåller både "Lorum" och "Ipsum." ****/
        /**********************************************************/

        //Om $data inte har något värde/text skrivet i sig så kommer koden inte leta efter det, men om $data har något värde så kommer det att användas vid sökningen då texten måste innehålla variabeln $data för att kunna visas.
        //Detta är samma kod som innan men inlägget måste nu innehålla någonting, vilket i detta fallet är $data (vad nu data har för ett värde, T.ex Kommer vilket bara ska visa 2 inlägg).
        if (!empty($data)) {
            $sql = 'SELECT p.ID, p.Slug, p.Headline, CONCAT(u.Firstname, " ", u.Lastname) AS Name, p.Creation_time, p.Text FROM Posts AS p JOIN Users AS u ON U.ID = P.User_ID WHERE p.Text LIKE "%'.$data.'%" ORDER BY P.Creation_time DESC';
        }
    }

    // Model får nu värdet array och för varje $pdo så kommer de att vissas på en ny rad med informationen som finns i $row
    $model = array();
    foreach($pdo->query($sql) as $row) {
        // Här får $row de värderna/CSS:n som den ska ha.
        $model += array(
            $row['ID'] => array(
                'slug' => $row['Slug'],
                'title' => $row['Headline'],
                'author' => $row['Name'],
                'date' => $row['Creation_time'],
                'text' => $row['Text']
            )
        );
    }
}
//fungerar inget av ovan så får man lite error
else {
    print_r($pdo->errorInfo());
}
?>
