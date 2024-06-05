delimiter //
CREATE OR REPLACE PROCEDURE `askAI`( IN  request JSON , OUT response TEXT )
BEGIN 
    SET @tn = JSON_Value( request, "$.__table_name" );
    IF @tn is null THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Table name is missing';
    END IF;

    IF @tn = 'questions' THEN
        select
        concat('Bitte bewerte den Schwierigkeitsgrad der Aufgabe, gibt dafür nur leicht, mittel oder schwer zurück: ',char(10),char(10), question)
        into response
        from questions
        where id = JSON_Value( request, "$.id" )

    END IF;

END //    