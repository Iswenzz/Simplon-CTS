class Abri
{
	private codeMission: number;
	private codePlanque: number;

	/**
	 * Initailize a new Abri object.
	 */
	public constructor(codeMission: number, codePlanque: number)
	{
		this.codeMission = codeMission;
		this.codePlanque = codePlanque;
	}

	/**
	 * Get the value of codeMission
	 */ 
	public getCodeMission(): number
	{
		return this.codeMission;
	}

	/**
	 * Set the value of codeMission
	 */ 
	public setCodeMission(codeMission: number): void
	{
		this.codeMission = codeMission;
	}

	/**
	 * Get the value of codePlanque
	 */ 
	public getCodePlanque(): number
	{
		return this.codePlanque;
	}

	/**
	 * Set the value of codePlanque
	 */ 
	public setCodePlanque(codePlanque: number): void
	{
		this.codePlanque = codePlanque;
	}
}
