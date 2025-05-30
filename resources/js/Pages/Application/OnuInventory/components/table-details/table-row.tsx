import { TableCell, TableRow } from "@/components/ui/table";
import { RxStatus } from "./rx-status";
import { GPonOnusDBMInterface } from "@/types/onu-names";
import { TxStatus } from "./tx-status";

export function TableDetailRow({ data }: { data: GPonOnusDBMInterface }) {
    return (
        <TableRow>
            <TableCell className="whitespace-nowrap">{data.NAME}</TableCell>
            <TableCell className="whitespace-nowrap">{data.SERIAL}</TableCell>
            <TableCell className="whitespace-nowrap">{data.DEVICE}</TableCell>
            <TableCell className="whitespace-nowrap">{data.PORT}</TableCell>
            <TableCell className="whitespace-nowrap">
                <RxStatus value={data.RXDBM} />
            </TableCell>
            <TableCell className="whitespace-nowrap">
                <TxStatus value={data.TXDBM} />
            </TableCell>
            <TableCell className="whitespace-nowrap">
                {data.COLLECTION_DATE}
            </TableCell>
        </TableRow>
    );
}
