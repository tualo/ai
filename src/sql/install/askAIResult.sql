delimiter //
CREATE OR REPLACE PROCEDURE `askAIResult`( IN  request JSON , in result JSON )
BEGIN 
    SET @tn = JSON_Value( request, "$.__table_name" );
    IF @tn is null THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Table name is missing';
    END IF;

    IF @tn = 'questions' THEN
        update 
            questions
        set ai_result = JSON_Value( request, "$.choices[0].message.content" )
        where id = JSON_Value( request, "$.id" );

    END IF;

END //    