export default interface JsonSerializable
{
	jsonSerialize(): Record<string, unknown>
}
