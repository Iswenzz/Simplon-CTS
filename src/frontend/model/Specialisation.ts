import Visee from "./Visee";

class Specilisation
{
	private codeSpecialite: number;
	private codeAgent: number;

	/**
	 * Initailize a new Specilisation object.
	 */
	public constructor(codeSpecialite: number, codeAgent: number)
	{
		this.codeSpecialite = codeSpecialite;
		this.codeAgent = codeAgent;
	}

	/**
	 * Get the value of codeSpecialite
	 */ 
	public getCodeSpecialite(): number
	{
		return this.codeSpecialite;
	}

	/**
	 * Set the value of codeSpecialite
	 */ 
	public setCodeSpecialite(codeSpecialite: number): void
	{
		this.codeSpecialite = codeSpecialite;
	}

	/**
	 * Get the value of codeAgent
	 */ 
	public getCodeAgent(): number
	{
		return this.codeAgent;
	}

	/**
	 * Set the value of codeAgent
	 */ 
	public setCodeAgent(codeAgent: number): void
	{
		this.codeAgent = codeAgent;
	}
}

export default Specilisation;