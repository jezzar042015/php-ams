DELIMITER //

CREATE PROCEDURE GetAccountActiveRatedCoverages (IN _accountid INT)

BEGIN
	SELECT policyid, policynumber, coveragetype 
	FROM policies 
	WHERE accountid = _accountid
		AND (premium IS NULL 
					AND (baseperunit > 0 
							OR PDRate > 0 
							OR trailerrate > 0 
							OR not_rate > 0 
							OR ti_rate > 0))
		AND (expiration >= current_date);
END //

DELIMITER ;