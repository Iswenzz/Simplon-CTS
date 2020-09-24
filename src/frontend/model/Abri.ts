import Model from "./Model";
import Visee from "./Visee";

class Abri extends Model
{
	private codeMission: number;
	private codePlanque: number;

	/**
	 * Initailize a new Abri object.
	 */
	public constructor(codeMission: number, codePlanque: number)
	{
		super();
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

export default Abri;