SELECT DiffTime.idOperazione,DiffTime.CodiceLettera, MINUTE(SEC_TO_TIME(AVG(TIME_TO_SEC(DiffTime.waitingTime)))) as waitingTimeAVG, MINUTE(SEC_TO_TIME(AVG(TIME_TO_SEC(DiffTime.servingTime)))) as servingTimeAVG 
FROM (SELECT ticket.Id,  
TIMEDIFF(ticket.OraChiamata , ticket.OraEmissione) as WaitingTime, TIMEDIFF(ticket.OraFine ,ticket.OraChiamata) as ServingTime,
OperazioniCentro.idOperazione, OperazioniCentro.CodiceLettera
from ticket, (select (sportelli.Id_Centro_ext) as idCentro,operazioni.id as idOperazione, operazioni.CodiceLettera,operazioni.Descrizione from sportelli,operazioni 
where sportelli.id_centro_ext=8 and sportelli.id_operazione_ext = operazioni.Id
group by operazioni.CodiceLettera  ) as OperazioniCentro

WHERE ticket.Id_centro_ext = OperazioniCentro.idcentro and ticket.Id_operazione_ext = OperazioniCentro.idOperazione) as DiffTime
GROUP BY DiffTime.IdOperazione