create function game_add() returns trigger
    language plpgsql
as
$$
BEGIN
    Insert into games_ranks("ID_game", name) VALUES (NEW."ID_game", 'Unranked');
    RETURN NEW;
END;
$$;

alter function game_add() owner to postgres;

CREATE TRIGGER game_add BEFORE INSERT OR UPDATE ON games
    FOR EACH ROW EXECUTE FUNCTION game_add();
