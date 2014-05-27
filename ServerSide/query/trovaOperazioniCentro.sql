select (sportelli.Id_Centro_ext) as idCentro,operazioni.id as idOperazione, operazioni.CodiceLettera,operazioni.Descrizione from sportelli,operazioni 
where sportelli.id_centro_ext=8 and sportelli.id_operazione_ext = operazioni.Id
group by operazioni.CodiceLettera 
