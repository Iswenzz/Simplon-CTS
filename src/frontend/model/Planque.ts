import JsonSerializable from "../JsonSerializable";
import Visee from "./Visee";

class Planque implements JsonSerializable
{
	private code: number | null;
	private adresse: string;
	private codePays: number;
	private codeType: number;

	/**
	 * Initailize a new Planque object.
	 */
	public constructor(code: number | null, adresse: string, codePays: number, codeType: number)
	{
		this.code = code;
		this.codePays = codePays;
		this.codeType = codeType;
		this.adresse = adresse;
	}

	/**
	 * Get the value of code
	 */ 
	public getCode(): number | null
	{
		return this.code;
	}

	/**
	 * Set the value of code
	 */ 
	public setCode(code: number | null): void
	{
		this.code = code;
	}

	/**
	 * Get the value of adresse
	 */ 
	public getAdresse(): string
	{
		return this.adresse;
	}

	/**
	 * Set the value of adresse
	 */ 
	public setAdresse(adresse: string): void
	{
		this.adresse = adresse;
	}

	/**
	 * Get the value of codePays
	 */ 
	public getCodePays(): number
	{
		return this.codePays;
	}

	/**
	 * Set the value of codePays
	 */ 
	public setCodePays(codePays: number): void
	{
		this.codePays = codePays;
	}

	/**
	 * Get the value of codeType
	 */ 
	public getCodeType(): number
	{
		return this.codeType;
	}

	/**
	 * Set the value of codeType
	 */ 
	public setCodeType(codeType: number): void
	{
		this.codeType = codeType;
	}

	/**
	 * Serialize the object.
	 */
	public jsonSerialize(): Record<string, unknown>
	{
		return {
			code: this.getCode(),
			adresse: this.getAdresse(),
			codePays: this.getCodePays(),
			codeType: this.getCodeType()
		};
	}
}

export default Planque;