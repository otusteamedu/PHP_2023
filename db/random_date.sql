Create or replace function random_date(limit_days integer) returns timestamp as
$$
declare
    result timestamp;
    days integer;
begin
    if limit_days < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    days := floor(random() * (30));
    if floor(random() * (2)) < 1 then
        result := now() - days * interval '1 day';
    else
        result := now() + days * interval '1 day';
    end if;
    return result;
end;
$$ language plpgsql;