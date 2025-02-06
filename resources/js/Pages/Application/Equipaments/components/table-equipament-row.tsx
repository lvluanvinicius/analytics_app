import { Button } from "@/components/ui/button";
import { TableCell, TableRow } from "@/components/ui/table";
import { EquipamentInterface } from "@/types/equipament";
import { Link } from "@inertiajs/react";
import { Edit, Eye } from "lucide-react";
import { Delete } from "./delete";
import { ViewPorts } from "./view-ports";

interface TableEquipamentsProps {
    data: EquipamentInterface;
}

export function TableEquipamentRow({ data }: TableEquipamentsProps) {
    return (
        <TableRow>
            <TableCell className="whitespace-nowrap">{data.id}</TableCell>
            <TableCell className="whitespace-nowrap">{data.name}</TableCell>
            <TableCell className="whitespace-nowrap">
                <ViewPorts data={data} />
            </TableCell>
            <TableCell className="whitespace-nowrap">
                <div className="flex items-center gap-2">
                    <Link href={route("app.equipaments.show", data.uuid)}>
                        <Button size={"icon"}>
                            <Eye />
                        </Button>
                    </Link>

                    <Link href={route("app.equipaments.edit", data.uuid)}>
                        <Button size={"icon"}>
                            <Edit />
                        </Button>
                    </Link>

                    <Delete equipament={data.uuid} />
                </div>
            </TableCell>
        </TableRow>
    );
}
